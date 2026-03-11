// Global variables
let conversations = [];
let currentConversationId = null;
let pendingImagePrompt;
let chatMemory = [];
let typeText = true;
let typeImage = false;
let typeWeb = false;
let feedback = document.getElementById('feedback');
const MAX_MESSAGES = 50;

const textSpan = document.getElementById('text');
const imageSpan = document.getElementById('image');
const webSpan = document.getElementById('web');

// Imposta per chat testuale (default)
textSpan.style.border = '1px solid red';

textSpan.addEventListener('click', () => {
    typeText = true;
    typeImage = false;
    typeWeb = false;
    textSpan.style.border = '1px solid red';
    imageSpan.style.border = '1px solid transparent';
    webSpan.style.border = '1px solid transparent';
    feedback.innerText = 'Text chat';
});

imageSpan.addEventListener('click', () => {
    typeText = false;
    typeImage = true;
    typeWeb = false;
    textSpan.style.border = '1px solid transparent';
    imageSpan.style.border = '1px solid red';
    webSpan.style.border = '1px solid transparent';
    feedback.innerText = 'Image generation';
});

webSpan.addEventListener('click', () => {
    typeText = false;
    typeImage = false;
    typeWeb = true;
    textSpan.style.border = '1px solid transparent';
    imageSpan.style.border = '1px solid transparent';
    webSpan.style.border = '1px solid red';
    feedback.innerText = 'Web search';
});

// Initialize
async function init() {
    loadApiKey();
    initSidebar();
    cleanupUploads();

    // Check for shared conversation in URL (legacy support)
    const urlParams = new URLSearchParams(window.location.search);
    const sharedToken = urlParams.get('conversation');
    if (sharedToken) {
        showToast('Questa versione non supporta più le conversazioni condivise. Le conversazioni sono ora temporanee.');
    }

    // Show warning if no API key
    const apiKey = getApiKeyForOpenAI();
    if (!apiKey) {
        showToast('Configura la tua API key da ⚙️ Setup per usare le funzionalità AI');
    }
}

// ===== SIDEBAR FUNCTIONS =====
function initSidebar() {
    setGreeting();
    document.getElementById('setup-api-key-btn').addEventListener('click', openApiKeyModal);
}

function setGreeting() {
    const userName = localStorage.getItem('eventailUserName');
    const greetingEl = document.getElementById('greeting');

    if (userName && userName.trim()) {
        greetingEl.textContent = `Ciao, ${userName}!`;
    } else {
        greetingEl.textContent = 'Benvenuto!';
    }
}

// ===== API KEY FUNCTIONS =====
function openApiKeyModal() {
    const apiKey = getApiKeyForOpenAI();
    if (apiKey) {
        document.getElementById('api-key-input').value = apiKey;
    }
    document.getElementById('api-key-modal').classList.add('active');
}

function closeApiKeyModal() {
    document.getElementById('api-key-modal').classList.remove('active');
}

function saveApiKey() {
    const apiKey = document.getElementById('api-key-input').value.trim();

    if (!apiKey) {
        showToast('Inserisci una API key valida');
        return;
    }

    localStorage.setItem('eventailAiApiKey', apiKey);
    closeApiKeyModal();
    showToast('✅ API Key salvata!');
}

function loadApiKey() {
    // No longer loads from config.txt - uses localStorage only
    console.log('API Key loaded from localStorage');
}

function getApiKeyForOpenAI() {
    return localStorage.getItem('eventailAiApiKey') || '';
}

// ===== IMAGE WARNING MODAL =====
function openImageWarning(prompt) {
    pendingImagePrompt = prompt;
    document.getElementById('image-warning-modal').classList.add('active');
}

function closeImageWarning() {
    document.getElementById('image-warning-modal').classList.remove('active');
}

function cancelImageGeneration() {
    pendingImagePrompt = null;
    document.getElementById('image-warning-modal').classList.remove('active');
}

async function proceedImageGeneration() {
    closeImageWarning();

    if (pendingImagePrompt) {
        const prompt = pendingImagePrompt;
        pendingImagePrompt = null;

        let conversation = conversations.find(c => c.id === currentConversationId);
        if (!conversation) {
            conversation = createNewConversation();
        }

        conversation.processing = true;
        renderCards();

        const imagePath = await generateCardImage(prompt);

        if (imagePath) {
            conversation.messages.push({ role: 'user', content: prompt });
            conversation.imageUrl = imagePath;
            conversation.type = 'image';
            conversation.updatedAt = new Date().toISOString();
            showToast('✅ Immagine condivisa pubblicamente!');
        } else {
            showToast('❌ Errore nella generazione dell\'immagine');
        }

        conversation.processing = false;
        renderCards();
    }
}

// ===== CLEANUP UPLOADS =====
async function cleanupUploads() {
    try {
        const response = await fetch('./php/cleanup-uploads.php');
        if (response.ok) {
            const result = await response.json();
            console.log('Cleanup result:', result);
        }
    } catch (error) {
        console.warn('Cleanup failed:', error);
    }
}

// ===== CONVERSATION MANAGEMENT =====
function createNewConversation() {
    const newId = Date.now().toString();
    const newConversation = {
        id: newId,
        title: 'Nuova Conversazione',
        messages: [],
        chatMemory: [
            { role: 'system', content: 'You are a general-knowledgebase skilled assistant who receives an input from the user and makes everything possible to find a correct answer or a valid help. You will not invent or make-up answers if you are not able to answer.' }
        ],
        createdAt: new Date().toISOString(),
        updatedAt: new Date().toISOString(),
        processing: false,
        imageUrl: null,
        type: null
    };

    conversations.unshift(newConversation);
    currentConversationId = newId;
    chatMemory = [...newConversation.chatMemory];

    return newConversation;
}

function createNewTopic() {
    createNewConversation();
    renderCards();
}

function verifyEnter(event) {
    if (event.key === 'Enter') {
        sendMessage();
    }
}

function verifyEnterModal(event) {
    if (event.key === 'Enter') {
        sendMessageFromModal();
    }
}

async function sendMessage() {
    const input = document.getElementById('user-input');
    const message = input.value.trim();

    if (!message) return;

    // Check API key for non-image operations
    const apiKey = getApiKeyForOpenAI();
    if (!apiKey && !typeImage) {
        showToast('⚠️ Configura la tua API Key da ⚙️ Setup per usare questa feature');
        return;
    }

    // For image generation, show warning modal
    if (typeImage) {
        openImageWarning(message);
        input.value = '';
        return;
    }

    let conversation = conversations.find(c => c.id === currentConversationId);
    if (!conversation) {
        conversation = createNewConversation();
    }

    input.value = '';

    conversation.messages.push({ role: 'user', content: message });
    conversation.type = typeWeb ? 'web' : 'text';
    conversation.updatedAt = new Date().toISOString();
    conversation.processing = true;
    renderCards();

    if (typeWeb) {
        await getChatGPTResponseWeb(message, conversation);
    } else {
        await getChatGPTResponse(message, conversation);
    }

    // Limit chat memory to MAX_MESSAGES
    limitChatMemory();

    renderCards();
}

async function sendMessageFromModal() {
    const input = document.getElementById('modal-user-input');
    const message = input.value.trim();

    if (!message) return;

    const apiKey = getApiKeyForOpenAI();
    if (!apiKey) {
        showToast('⚠️ Configura la tua API Key da ⚙️ Setup per usare questa feature');
        return;
    }

    let conversation = conversations.find(c => c.id === currentConversationId);
    if (!conversation) return;

    input.value = '';

    // Show user message in modal
    showMessageInModal('user', message);

    // Add to conversation
    conversation.messages.push({ role: 'user', content: message });
    conversation.updatedAt = new Date().toISOString();

    if ((conversation.type || (typeWeb ? 'web' : 'text')) === 'web') {
        await getChatGPTResponseWeb(message, conversation);
    } else {
        await getChatGPTResponse(message, conversation);
    }

    // Limit chat memory
    limitChatMemory();

    renderCards();
}
