# Éventail-AI: Lightweight Stateless AI Assistant

*A new way to conceive your AI interactions*

---

## Quick Overview

Éventail-AI is an elegant, all-in-one AI assistant that brings together text chat, image generation, and web search in a beautifully designed interface. With a focus on simplicity and statelessness, Éventail-AI provides temporary conversation sessions and public image sharing, making it perfect for quick interactions, creative exploration, and collaborative visual projects.

---

## Key Features

- **Multi-modal AI interactions** – Seamlessly switch between text chat, image generation, and web search with a single click
- **Circular "fan" card interface** – Navigate your conversations through an elegant, iridescent bubble layout
- **Lightweight & stateless** – Conversations live only in session memory (max 50 messages), keeping the app fast and simple
- **Public image gallery** – All generated images are visible to all users in a shared gallery
- **LocalStorage API key** – Your OpenAI API key is stored securely in your browser
- **Auto-cleanup uploads** – Temporary analysis files automatically cleaned (500MB limit)
- **Conversation export** – Save your conversations as JSON files before closing the session

---

## How It Works

**1. Setup Your API Key** – Click "⚙️ Setup API Key" in the sidebar and enter your OpenAI API key

**2. Select Your Mode** – Choose between text chat (📋), image generation (🖼️), or web search (🌎) using emoji triggers

**3. Enter Your Prompt** – Type your question, request, or idea into the input field and let AI work

**4. Interact & Explore** – Watch responses stream in real-time with smooth animations. Copy text to clipboard, view images in full detail, or follow web search citations

**5. Temporary Conversations** – Your messages live in the current session only (max 50). Export important conversations before refreshing

**6. Public Image Gallery** – Generated images are automatically shared with all users. Visit the "Public Generations" page to see what others have created

*Visual cues guide you through every step: processing states show with an orange border, completed conversations display with smooth animations, and hover effects reveal additional options.*

---

## Important Notes

⚠️ **Conversations are Temporary**
- Messages are saved only in the current browser session
- Maximum 50 messages per conversation
- Refreshing the page will lose all conversations
- Export important conversations as JSON before closing

🖼️ **Images are Public**
- All generated images are visible to all users
- A warning is shown before generating each image
- Images appear in the "Public Generations" gallery
- Metadata includes: timestamp, prompt, and file size

---

## Interaction Modes

### 📋 Text Chat

Engage in real-time conversations with GPT-4o-mini. Each exchange maintains full conversation memory up to 50 messages, so context flows naturally. Responses stream in with a typing indicator, and you can copy any response to your clipboard with a single click.

**Perfect for:** Brainstorming, creative writing, explaining concepts, getting feedback on ideas

### 🖼️ Image Generation

Create stunning visuals with DALL-E 2 in a 512×512 format. Simply describe what you want to see, confirm the public sharing warning, and watch as your image materializes. Each generated image is automatically saved to the public gallery with metadata.

**Perfect for:** Project visuals, concept art, social media images, creative exploration

**Note:** All generated images are public and visible to all users in the Public Generations gallery.

### 🌎 Web Search

Get real-time information from the web with AI-powered search integration. Responses include source citations below each answer, so you can verify facts and dive deeper into any topic. This mode combines the conversational ease of ChatGPT with the latest information from the internet.

**Perfect for:** Current events, research, fact-checking, learning about recent developments

---

## Public Image Gallery

The "Public Generations" page showcases all images created by users of Éventail-AI:

- **Real-time updates** – Page auto-refreshes every 30 seconds
- **Full metadata** – View prompt, timestamp, and file size for each image
- **Full-size view** – Click any image to see it in full resolution
- **Responsive grid** – 3 columns on desktop, 2 on tablet, 1 on mobile
- **Lazy loading** – Efficient loading even with many images

**Access:** Click "🖼️ Public Generations" in the sidebar

---

## Conversation Memory

**50 Message Limit**
- Conversations are limited to 50 messages (excluding system prompt)
- When the limit is reached, oldest messages are removed (FIFO)
- System prompt is always preserved
- This keeps conversations manageable and performance high

**Session-Based Storage**
- Conversations exist only in JavaScript memory
- No server-side persistence
- No localStorage of conversations (only API key)
- Page refresh = conversation reset

**Export Functionality**
- Click "📥 Export" in any conversation modal
- Downloads conversation as JSON file
- Format: `conversation_YYYY-MM-DDTHH-MM-SS.json`
- Includes all messages, metadata, and timestamps

---

## API Key Management

**LocalStorage-Based**
- API key is stored in browser's localStorage
- Key: `eventailAiApiKey`
- Persists across browser sessions
- Only you have access (not sent to server)

**Setup Process**
1. Click "⚙️ Setup API Key" in sidebar
2. Enter your OpenAI API key (starts with `sk-`)
3. Click "Salva"
4. Confirmation toast appears

**No Config File**
- Old config.txt method is deprecated
- All API calls use localStorage key
- If key is missing, you'll see a warning toast

---

## Upload Folder Management

**Auto-Cleanup System**
- Temporary analysis files stored in `/uploads/`
- Hidden from UI (not accessible via web browser)
- Automatically checked on page load
- If > 500MB: deletes 10 oldest files (FIFO)
- Repeats until under 500MB limit

**Security**
- Directory protected with .htaccess: "Deny from all"
- Not visible from web interface
- Used only for temporary file processing

---

## File Structure

```
/eventail_ai/
├── eventail.php (main application)
├── users-generations.html (public image gallery)
├── /cardimages/ (public images with metadata)
│   ├── img_*.png
│   └── img_*.json
├── /uploads/ (hidden, auto-cleaned)
│   └── .htaccess (Deny from all)
└── /php/
    ├── save-card-image.php (saves image + metadata)
    ├── get-all-generations.php (retrieves all images)
    └── cleanup-uploads.php (auto-cleanup script)
```

---

## Visual Design Highlights

**Elegant Gradient Background** – A smooth purple-to-deep-purple gradient creates a calming, professional atmosphere that's easy on the eyes for extended sessions.

**Circular "Éventail" Layout** – The signature fan arrangement of conversation cards rotates smoothly around a central point, creating a dynamic, organic feel that's unlike any other AI interface.

**Iridescent Bubble Effect** – Each conversation card features a subtle soap bubble aesthetic with rainbow highlights that shift as you move your mouse, adding depth and playfulness to the interface.

**Responsive Design** – Seamlessly adapts to any screen size—mobile, tablet, or desktop—maintaining beautiful fan layout while optimizing for touch interactions on smaller devices.

**Simplified Sidebar** – Clean, uncluttered sidebar with essential actions only: setup API key and access public gallery.

**Modern Modal Interface** – Detailed conversations open in elegant modal windows with full chat history, citations, and export button.

---

## Key Strengths

**Lightweight & Fast** – No database, no server persistence, just JavaScript session memory and minimal PHP endpoints.

**Intuitive Interface** – The minimalist design and emoji-based mode selection mean anyone can start using Éventail-AI in seconds—no technical knowledge required.

**Public Creativity** – Shared image gallery inspires users and showcases community creativity.

**Privacy-Conscious** – API key stored locally in your browser, not on servers. Conversations are temporary by design.

**No Dependencies** – Pure vanilla JavaScript means no npm packages, no complex build processes, and lightning-fast load times.

**Auto-Maintenance** – Upload folder auto-cleans itself, preventing disk space issues.

**Simple Setup** – Just set your API key and start creating—no account registration required.

---

## Use Cases

**Quick Creative Brainstorming** – Generate ideas and images in temporary sessions. Export what you need, then start fresh.

**Visual Inspiration** – Browse the public image gallery for creative ideas and inspiration from other users.

**Web Research** – Use web search mode to get current information with citations, explore follow-up questions—all in a lightweight session.

**Concept Visualization** – Generate images for presentations, social media, or projects. Your creations become part of the public gallery.

**Learning & Exploration** – Engage in text conversations to explore topics, then export valuable insights as JSON for later reference.

**Mobile AI Assistant** – Fast, responsive interface perfect for on-the-go AI interactions without the overhead of persistent storage.

---

## Conversation Lifecycle

```
Open eventail.php → Setup API Key (if needed)
                        ↓
              Create new topic / Select mode (📋 🖼️ 🌎)
                        ↓
                Chat / Generate / Search (up to 50 messages)
                        ↓
                 AI responds with streaming
                        ↓
          📥 Export conversation as JSON (before refresh!)
                        ↓
           🔄 Page refresh → Conversation lost (by design)
                        ↓
          🖼️ Images saved to public gallery permanently
```

---

## Technical Details

### JavaScript Architecture

**State Management**
- Conversations array in JavaScript memory
- Current conversation ID tracking
- Chat memory array (max 50 messages)
- API key in localStorage

**No Persistence Layer**
- No localStorage for conversations
- No server-side database
- No file-based conversation storage
- Session-only by design

### PHP Endpoints

**save-card-image.php**
- POST endpoint
- Accepts: `{ imageData, prompt, timestamp }`
- Saves image to `/cardimages/img_*.png`
- Creates metadata JSON file
- Returns: `{ success, filepath }`

**get-all-generations.php**
- GET endpoint
- Reads all `.json` files in `/cardimages/`
- Returns sorted by timestamp (newest first)
- Returns: `{ success, generations: [...] }`

**cleanup-uploads.php**
- GET endpoint
- Checks `/uploads/` folder size
- Deletes oldest files if > 500MB (10 at a time)
- Returns: `{ success, deletedCount, finalSize }`

### Browser Compatibility

**Required**
- Modern browser with localStorage support
- Fetch API support
- ES6+ JavaScript support

**Recommended**
- Chrome 90+, Firefox 88+, Safari 14+, Edge 90+
- JavaScript enabled
- Cookies enabled (for some features)

---

## Security & Privacy

**API Key Storage**
- Stored in browser's localStorage (client-side only)
- Never sent to server
- You control your own key

**Temporary Conversations**
- No server persistence means conversations aren't stored
- More privacy by design
- Export important data before closing session

**Public Images**
- Warning shown before each image generation
- Users opt-in to sharing
- No personal data in images (only prompt)

**Upload Folder Security**
- Protected with .htaccess
- Not accessible via web browser
- Auto-cleaned regularly

---

## FAQ

**Q: Why are conversations temporary?**  
A: This keeps the app lightweight and fast. No database, no complex state management—just clean, simple interactions.

**Q: Can I keep my conversations?**  
A: Yes! Use the "📥 Export" button in any conversation modal to download it as JSON before refreshing.

**Q: Are my images really public?**  
A: Yes, all generated images are visible to all users in the Public Generations gallery. A warning is shown before each generation.

**Q: What happens if I refresh the page?**  
A: You'll lose all current conversations. A warning banner reminds you to export before closing.

**Q: Is my API key safe?**  
A: Yes, it's stored in your browser's localStorage only, never sent to our servers.

**Q: How do I access the public image gallery?**  
A: Click "🖼️ Public Generations" in the sidebar.

**Q: Can I delete my images?**  
A: Currently, images remain in the public gallery. Contact admin for removal requests.

**Q: What's the message limit?**  
A: 50 messages per conversation. Oldest messages are removed when limit is exceeded.

---

## Closing Statement

Éventail-AI embraces a minimalist philosophy: stateless conversations, public creativity sharing, and lightning-fast performance. It transforms artificial intelligence from a complex, heavy application into a lightweight, beautiful tool for quick interactions and visual inspiration—where ideas flow, images are shared, and the experience remains refreshingly simple.

Ready to explore a lighter way of thinking with AI?

---

## Documentation

For detailed technical information about the refactoring, see [REFACTORING.md](REFACTORING.md).
