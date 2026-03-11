function limitChatMemory() {
    // Keep only last MAX_MESSAGES (excluding system message)
    if (chatMemory.length > MAX_MESSAGES + 1) { // +1 for system message
        chatMemory = [chatMemory[0], ...chatMemory.slice(-MAX_MESSAGES)];
    }
}

async function getChatGPTResponse(userInput, conversation) {
    const apiKey = getApiKeyForOpenAI();
    if (!apiKey) {
        showToast('⚠️ API Key non configurata');
        return;
    }

    const typingIndicator = document.createElement('p');
    typingIndicator.id = 'typing-indicator';
    typingIndicator.textContent = 'Scrivendo...';

    const chatContainer = document.getElementById('chat-container');
    if (chatContainer && document.getElementById('chat-modal').classList.contains('active')) {
        chatContainer.appendChild(typingIndicator);
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }

    try {
        const response = await fetch('https://api.openai.com/v1/chat/completions', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + apiKey
            },
            body: JSON.stringify({
                model: 'gpt-4o-mini',
                messages: [...chatMemory, { role: 'user', content: userInput }]
            })
        });

        if (!response.ok) throw new Error('Errore durante la richiesta API.');

        const data = await response.json();
        if (typingIndicator.parentNode) typingIndicator.remove();

        const chatGPTResponse = data.choices?.[0]?.message?.content?.trim() || '';

        // Add to conversation
        conversation.messages.push({
            role: 'assistant',
            content: chatGPTResponse
        });

        conversation.updatedAt = new Date().toISOString();

        // Update memory
        chatMemory.push({ role: 'user', content: userInput });
        chatMemory.push({ role: 'assistant', content: chatGPTResponse });

        // Show in modal if open
        if (document.getElementById('chat-modal').classList.contains('active')) {
            showMessageInModal('assistant', chatGPTResponse);
        }

        limitChatMemory();
        conversation.chatMemory = [...chatMemory];
    } catch (error) {
        console.error(error);
        if (typingIndicator.parentNode) typingIndicator.remove();
        showToast('Errore nella comunicazione con l\'API.');
    } finally {
        conversation.processing = false;
    }
}

async function generateCardImage(prompt) {
    const apiKey = getApiKeyForOpenAI();
    if (!apiKey) {
        showToast('⚠️ API Key non configurata');
        return null;
    }

    try {
        const imgResponse = await fetch('https://api.openai.com/v1/images/generations', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + apiKey
            },
            body: JSON.stringify({
                model: 'dall-e-2',
                prompt,
                size: '512x512',
                response_format: 'b64_json'
            })
        });

        if (!imgResponse.ok) {
            console.warn('Errore generazione immagine');
            return null;
        }

        const data = await imgResponse.json();
        const base64 = data.data[0].b64_json;

        const saveResponse = await fetch('php/save-card-image.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                imageData: base64,
                prompt,
                timestamp: new Date().toISOString()
            })
        });

        const result = await saveResponse.json();
        if (result.success) {
            console.log('Immagine salvata:', result.filepath);
            return result.filepath;
        }

        console.warn('Errore salvataggio immagine:', result.error);
        return null;
    } catch (err) {
        console.error('Errore generazione immagine:', err);
        return null;
    }
}

async function getChatGPTResponseWeb(userInput, conversation) {
    const apiKey = getApiKeyForOpenAI();
    if (!apiKey) {
        showToast('⚠️ API Key non configurata');
        return;
    }

    const chatContainer = document.getElementById('chat-container');

    const typingIndicator = document.createElement('p');
    typingIndicator.id = 'typing-indicator';
    typingIndicator.textContent = 'Ricerca in corso...';
    if (chatContainer) {
        chatContainer.appendChild(typingIndicator);
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }

    try {
        const response = await fetch('https://api.openai.com/v1/chat/completions', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + apiKey
            },
            body: JSON.stringify({
                model: 'gpt-4o-mini-search-preview',
                web_search_options: { search_context_size: 'medium' },
                messages: [...chatMemory, { role: 'user', content: userInput }]
            })
        });

        if (!response.ok) throw new Error('Errore durante la richiesta API.');

        const data = await response.json();
        if (typingIndicator.parentNode) typingIndicator.remove();

        const chatGPTResponse = data.choices?.[0]?.message?.content?.trim() || '';
        const annotations = data.choices?.[0]?.message?.annotations || [];
        const citations = [];

        // Extract citations
        annotations.forEach(a => {
            if (a.type === 'url_citation' && a.url_citation?.url) {
                citations.push({
                    title: a.url_citation.title || a.url_citation.url,
                    url: a.url_citation.url
                });
            }
        });

        // Clean response
        const cleanResponse = cleanResponseText(chatGPTResponse, annotations);

        // Update conversation
        conversation.messages.push({
            role: 'assistant',
            content: cleanResponse,
            citations
        });
        conversation.updatedAt = new Date().toISOString();

        // Update memory
        chatMemory.push({ role: 'user', content: userInput });
        chatMemory.push({ role: 'assistant', content: cleanResponse });

        // Show in modal if open
        if (document.getElementById('chat-modal').classList.contains('active')) {
            showMessageInModal('assistant', cleanResponse);
            if (citations.length > 0) {
                appendCitationsToModal(citations);
            }
        }

        limitChatMemory();
        conversation.chatMemory = [...chatMemory];
    } catch (error) {
        console.error(error);
        if (typingIndicator.parentNode) typingIndicator.remove();
        showToast('Errore nella comunicazione con l\'API Web.');
    } finally {
        conversation.processing = false;
    }
}

function cleanResponseText(response, citations) {
    const citationUrls = citations
        .filter(a => a.type === 'url_citation' && a.url_citation?.url)
        .map(a => a.url_citation.url);

    let cleaned = response;
    citationUrls.forEach(url => {
        const urlRegex = new RegExp(url.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'), 'g');
        cleaned = cleaned.replace(urlRegex, '');
    });

    cleaned = cleaned
        .replace(/https?:\/\/[^\s]+/g, '')
        .replace(/[ ]{2,}/g, ' ')
        .replace(/\*\*(.*?)\*\*/g, '$1')
        .trim();

    return cleaned;
}
