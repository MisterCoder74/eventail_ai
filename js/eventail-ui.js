function appendCitationsToModal(citations) {
    const container = document.getElementById('chat-container');
    if (!container) return;

    const block = document.createElement('div');
    block.className = 'citations-block';

    const title = document.createElement('p');
    title.textContent = 'Fonti:';
    block.appendChild(title);

    citations.forEach(c => {
        const link = document.createElement('a');
        link.href = c.url;
        link.target = '_blank';
        link.rel = 'noopener noreferrer';
        link.textContent = c.title;
        block.appendChild(link);
    });

    container.appendChild(block);
    container.scrollTop = container.scrollHeight;
}

function escapeHTML(str) {
    return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
}

function showMessageInModal(role, message) {
    const container = document.getElementById('chat-container');
    const msgDiv = document.createElement('div');
    msgDiv.className = 'message ' + (role === 'user' ? 'user-message' : 'chatgpt-message');

    if (role === 'assistant') {
        msgDiv.innerHTML = formatMessage(message);

        // Add copy button
        const copyBtn = document.createElement('button');
        copyBtn.className = 'copy-btn';
        copyBtn.textContent = 'Copia';
        copyBtn.onclick = () => copyToClipboard(message);
        msgDiv.appendChild(copyBtn);
    } else {
        msgDiv.textContent = message;
    }

    container.appendChild(msgDiv);
    container.scrollTop = container.scrollHeight;
}

function formatMessage(text) {
    // Format code blocks
    const codeBlockRegex = /```(\w*)\n([\s\S]*?)```/g;
    text = text.replace(codeBlockRegex, (match, lang, code) => {
        return `<div class="message-code-block"><pre><code class="language-${lang}">${escapeHTML(code)}</code></pre></div>`;
    });

    // Format inline code
    text = text.replace(/`([^`]+)`/g, '<code>$1</code>');

    // Format paragraphs
    text = text.split('\n\n').map(p => `<p>${p.replace(/\n/g, '<br>')}</p>`).join('');

    return text;
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        showToast('Copiato!');
    }).catch(() => {
        showToast('Errore nella copia');
    });
}

function displayConversationMessages(conversation) {
    const container = document.getElementById('chat-container');
    container.innerHTML = '';

    if (conversation.type === 'image') {
        const userPrompt = conversation.messages.find(m => m.role === 'user');
        if (userPrompt) {
            const userMsg = document.createElement('div');
            userMsg.className = 'message user-message';
            userMsg.textContent = userPrompt.content;
            container.appendChild(userMsg);
        }

        if (conversation.imageUrl) {
            const imgWrapper = document.createElement('div');
            imgWrapper.className = 'modal-image-wrapper';
            const img = document.createElement('img');
            img.src = conversation.imageUrl;
            imgWrapper.appendChild(img);
            container.appendChild(imgWrapper);
        }
    } else {
        conversation.messages.forEach(msg => {
            showMessageInModal(msg.role, msg.content);

            if (msg.citations && msg.citations.length > 0) {
                appendCitationsToModal(msg.citations);
            }
        });
    }
}

// ===== RENDER CARDS =====
function renderCards() {
    const container = document.getElementById('cards-container');
    container.innerHTML = '';

    if (conversations.length === 0) {
        container.innerHTML = '<p style="text-align: center; color: #000; width: 100%;">Nessuna conversazione. Inizia creando un nuovo topic!</p>';
        return;
    }

    conversations.forEach(conv => {
        const card = document.createElement('div');
        const isActive = conv.id === currentConversationId;
        const isProcessing = conv.processing || false;
        card.className = 'chat-card' + (isActive ? ' active' : '') + (isProcessing ? ' processing' : '');

        // Background image
        if (conv.imageUrl) {
            card.style.backgroundImage = `url(${conv.imageUrl})`;
            card.style.backgroundSize = 'cover';
            card.style.backgroundPosition = 'center';
            card.style.color = '#000';
        }

        const firstMessage = conv.messages.find(m => m.role === 'user');
        const lastMessage = conv.messages[conv.messages.length - 1];

        let preview = '';
        if (conv.type === 'image') {
            preview = 'Immagine generata';
        } else if (lastMessage && lastMessage.role === 'assistant') {
            preview = lastMessage.content.substring(0, 250);
        } else if (firstMessage) {
            preview = firstMessage.content.substring(0, 250);
        } else {
            preview = 'Nessun messaggio';
        }

        const messagesCount = conv.messages.length;
        const date = new Date(conv.updatedAt).toLocaleDateString('it-IT');

        const cardHeader = document.createElement('div');
        cardHeader.className = 'card-header';

        const cardTitle = document.createElement('h3');
        cardTitle.className = 'card-title';
        cardTitle.textContent = conv.title;

        const deleteBtn = document.createElement('button');
        deleteBtn.className = 'delete-btn';
        deleteBtn.textContent = '×';
        deleteBtn.onclick = e => deleteConversation(conv.id, e);

        const cardPreview = document.createElement('div');
        cardPreview.className = 'card-preview';
        cardPreview.textContent = preview;

        const cardMeta = document.createElement('div');
        cardMeta.className = 'card-meta';

        const messagesSpan = document.createElement('span');
        messagesSpan.textContent = `${messagesCount} messaggi`;

        const dateSpan = document.createElement('span');
        dateSpan.textContent = date;

        cardMeta.appendChild(messagesSpan);
        cardMeta.appendChild(dateSpan);
        cardHeader.appendChild(cardTitle);
        cardHeader.appendChild(deleteBtn);
        card.appendChild(cardHeader);
        card.appendChild(cardPreview);
        card.appendChild(cardMeta);

        card.onclick = e => {
            if (!e.target.classList.contains('delete-btn')) {
                openModal(conv.id);
            }
        };

        container.appendChild(card);
    });

    // Fan effect
    const cards = container.querySelectorAll('.chat-card');
    const total = cards.length;

    if (total === 1) {
        cards[0].style.transform = 'rotate(0deg) translateY(0px)';
    } else {
        const screenWidth = window.innerWidth;
        let maxAngle;
        let offsetMultiplier;

        if (screenWidth < 768) {
            maxAngle = 5;
            offsetMultiplier = 0.5;
        } else if (screenWidth < 1024) {
            maxAngle = 8;
            offsetMultiplier = 0.7;
        } else {
            maxAngle = 10;
            offsetMultiplier = 0.8;
        }

        cards.forEach((card, i) => {
            const angle = ((i / (total - 1)) - 0.5) * 2 * maxAngle;
            const offsetY = Math.abs(angle) * offsetMultiplier;
            card.style.transform = `rotate(${angle}deg) translateY(${offsetY}px)`;
        });
    }
}

function deleteConversation(id, event) {
    event.stopPropagation();
    if (confirm('Eliminare questa conversazione?')) {
        conversations = conversations.filter(c => c.id !== id);
        if (currentConversationId === id) currentConversationId = null;
        renderCards();
    }
}

function openModal(conversationId) {
    currentConversationId = conversationId;
    const conversation = conversations.find(c => c.id === conversationId);
    if (!conversation) return;

    document.getElementById('modal-title').textContent = conversation.title;
    const modal = document.getElementById('chat-modal');
    const container = document.getElementById('chat-container');
    container.innerHTML = '';
    modal.classList.add('active');

    // Restore memory for this conversation
    chatMemory = conversation.chatMemory || [
        { role: 'system', content: 'You are a general-knowledgebase skilled assistant who receives an input from the user and makes everything possible to find a correct answer or a valid help. You will not invent or make-up answers if you are not able to answer.' }
    ];

    // Modal visibility based on type
    if (conversation.type === 'image') {
        document.getElementById('modal-prompt').style.display = 'none';
    } else {
        document.getElementById('modal-prompt').style.display = 'flex';
    }

    displayConversationMessages(conversation);
    renderCards();
}

function closeModal() {
    document.getElementById('chat-modal').classList.remove('active');
    document.getElementById('chat-container').innerHTML = '';
}

// ===== EXPORT CONVERSATION =====
function exportConversation() {
    const conversation = conversations.find(c => c.id === currentConversationId);
    if (!conversation) {
        showToast('Nessuna conversazione da esportare');
        return;
    }

    // Export as JSON
    const json = JSON.stringify(conversation, null, 2);
    const blob = new Blob([json], { type: 'application/json' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `conversation_${conversation.createdAt.replace(/[:.]/g, '-')}.json`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);

    showToast('✅ Conversazione esportata!');
}

// ===== TOAST NOTIFICATION =====
function showToast(message) {
    const toast = document.getElementById('toast');
    toast.textContent = message;
    toast.classList.add('show');

    setTimeout(() => {
        toast.classList.remove('show');
    }, 3000);
}

// Recalculate fan on resize
let resizeTimer;
window.addEventListener('resize', () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => {
        renderCards();
    }, 250);
});

window.onload = init;
