import "./bootstrap";
import "./echo";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

let typingTimer;

let onlineUsers = [];
let activeTypers = [];

const conversationId = document.getElementById("conversation-id");

if (conversationId) {
    window.Echo.private(`conversation.${conversationId.value}`)
        .listen("MessageSent", (e) => {
            console.log("EVENT RECEIVED");

            const messagesDiv = document.getElementById("messages");

            const currentUserId =
                document.getElementById("current-user-id").value;

            const isMine = e.user_id == currentUserId;

            const html = `
            <div class="flex ${isMine ? "justify-end" : "justify-start"}">

                <div class="
                    max-w-sm px-4 py-2 rounded-lg shadow
                    ${isMine ? "bg-green-500 text-white" : "bg-white"}
                ">

                    ${
                        !isMine
                            ? `
                        <div class="text-xs font-semibold text-green-600 mb-1">
                            ${e.user_name}
                        </div>
                    `
                            : ""
                    }

                    <p>${e.body}</p>

                    <div class="text-xs mt-1 opacity-70">
                        ${e.created_at}
                    </div>

                </div>

            </div>
            `;

            messagesDiv.insertAdjacentHTML("beforeend", html);

            messagesDiv.scrollTop = messagesDiv.scrollHeight;
        })
        .listenForWhisper("typing", (e) => {
            const typingIndicator = document.getElementById("typing-indicator");

            if (!activeTypers.includes(e.name)) {
                activeTypers.push(e.name);
            }

            typingIndicator.innerText = activeTypers
                .map((name) => `${name} is typing...`)
                .join(" ");

            setTimeout(() => {
                activeTypers = activeTypers.filter((name) => name !== e.name);

                typingIndicator.innerText = activeTypers
                    .map((name) => `${name} is typing...`)
                    .join(" ");
            }, 1000);
        });
    
    window.Echo.join(`presence.conversation.${conversationId.value}`)
        .here((users) => {
            onlineUsers = users;

            updateStatus();
        })
        .joining((user) => {
            onlineUsers.push(user);

            updateStatus();
        })
        .leaving((user) => {
            onlineUsers = onlineUsers.filter((u) => u.id !== user.id);

            updateStatus();
        });
}

const form = document.getElementById("message-form");

if (form) {
    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const input = document.getElementById("message-input");

        const body = input.value;

        if (!body.trim()) return;

        const response = await fetch(form.action, {
            method: "POST",

            headers: {
                "Content-Type": "application/json",

                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]',
                ).content,

                Accept: "application/json",
            },

            body: JSON.stringify({
                body,
            }),
        });

        await response.json();

        input.value = "";
    });
}

function updateStatus() {
    const status = document.getElementById("user-status");

    if (!status) return;

    const currentUserId = Number(
        document.getElementById("current-user-id").value,
    );

    const otherUserOnline = onlineUsers.some(
        (user) => user.id !== currentUserId,
    );

    if (otherUserOnline) {
        status.innerText = "🟢 Online";
    } else {
        const lastSeen = status.dataset.lastSeen;

        status.innerText = lastSeen ? `Last seen ${lastSeen}` : "Offline";
    }
}

function scrollToBottom() {
    const messagesDiv = document.getElementById("messages");

    if (!messagesDiv) return;

    messagesDiv.scrollTo({
        top: messagesDiv.scrollHeight,
        behavior: "smooth",
    });
}

scrollToBottom();

const messageInput = document.getElementById("message-input");
if (conversationId && messageInput) {
    messageInput.addEventListener("input", () => {
        clearTimeout(typingTimer);

        typingTimer = setTimeout(() => {
            window.Echo.private(`conversation.${conversationId.value}`).whisper(
                "typing",
                {
                    id: document.getElementById("current-user-id").value,
                    name: document.getElementById("current-user-name").value,
                },
            );
        }, 300);
    });
}
