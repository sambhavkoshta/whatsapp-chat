import "./bootstrap";
import "./echo";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

const conversationId = document.getElementById("conversation-id");

if (conversationId) {
    window.Echo.private(`conversation.${conversationId.value}`).listen(
        "MessageSent",
        (e) => {
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

                <p>${e.body}</p>

                <div class="text-xs mt-1 opacity-70">
                    ${e.created_at}
                </div>

            </div>

        </div>
    `;

            messagesDiv.insertAdjacentHTML("beforeend", html);

            messagesDiv.scrollTop = messagesDiv.scrollHeight;
        },
    );
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

        const message = await response.json();

        const messagesDiv = document.getElementById("messages");

        const html = `
            <div class="flex justify-end">

                <div class="
                    max-w-sm px-4 py-2 rounded-lg shadow
                    bg-green-500 text-white
                ">

                    <p>${message.body}</p>

                    <div class="text-xs mt-1 opacity-70">
                        ${message.created_at}
                    </div>

                </div>

            </div>
        `;

        messagesDiv.insertAdjacentHTML("beforeend", html);

        messagesDiv.scrollTop = messagesDiv.scrollHeight;

        input.value = "";

        input.value = "";
    });
}


