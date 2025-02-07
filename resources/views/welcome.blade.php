<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini Réseau Social</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1280px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
        }

        .message-form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .message-form input,
        .message-form textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .message-form button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 5px;
        }

        .message {
            background: #fff;
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.1);
        }

        .message .meta {
            font-size: 0.9em;
            color: gray;
        }

        .like-btn, .comment-btn {
            background: none;
            border: none;
            color: blue;
            cursor: pointer;
            margin-right: 10px;
        }

        .comments {
            margin-top: 10px;
            padding-left: 20px;
            border-left: 2px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Mini Réseau Social</h1>
        <!-- Formulaire d'envoi de message -->
        <div class="message-form">
            <input type="text" id="username" placeholder="Votre nom">
            <textarea id="message" placeholder="Votre message"></textarea>
            <button onclick="sendMessage()">Envoyer</button>
        </div>

        <!-- Liste des messages -->
        <div id="messages-container"></div>

        <!-- Pagination -->
        <div class="pagination">
            <button onclick="prevPage()">Précédent</button>
            <span id="page-number">Page 1</span>
            <button onclick="nextPage()">Suivant</button>
        </div>
    </div>

    <script>
  
        let currentPage = 1;
        const messagesPerPage = 10;
        const apiBaseUrl = "/api";
        // Charger les messages au démarrage
        document.addEventListener("DOMContentLoaded", () => {
            loadMessages();
        });

        // Charger les messages
        function loadMessages() {
            fetch(`${apiBaseUrl}/messages?nb_message=${messagesPerPage}&page=${currentPage}`)
                .then(response => response.json())
                .then(data => {
                    const messagesContainer = document.getElementById("messages-container");
                    messagesContainer.innerHTML = "";

                    data.data.forEach(message => {
                        const messageDiv = document.createElement("div");
                        messageDiv.classList.add("message");
                        messageDiv.innerHTML = `
                            <p><strong>${message.username}</strong>: ${message.content}</p>
                            <p class="meta">${new Date(message.created_at).toLocaleString()}</p>
                            <button class="like-btn" onclick="likeMessage(${message.id})">❤️ ${message.like || 0}</button>
                            <button class="comment-btn" onclick="toggleComments(${message.id})">💬 Commentaires</button>
                            <div class="comments" id="comments-${message.id}" style="display: none;"></div>
                            <div class="comment-form" id="comment-form-${message.id}" style="display: none;">
                                <input type="text" id="comment-username-${message.id}" placeholder="Votre nom">
                                <input type="text" id="comment-content-${message.id}" placeholder="Votre commentaire">
                                <button onclick="sendComment(${message.id})">Ajouter</button>
                            </div>
                        `;
                        messagesContainer.appendChild(messageDiv);
                    });

                    document.getElementById("page-number").innerText = `Page ${currentPage}`;
                })
                .catch(error => console.error("Erreur chargement messages:", error));
        }

        // Envoyer un message
        function sendMessage() {
            const username = document.getElementById("username").value;
            const content = document.getElementById("message").value;

            fetch(`${apiBaseUrl}/message`, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ username, content })
            })
            .then(() => {
                document.getElementById("message").value = "";
                loadMessages();
            })
            .catch(error => console.error("Erreur envoi message:", error));
        }

        // Gérer la pagination
        function prevPage() {
            if (currentPage > 1) {
                currentPage--;
                loadMessages();
            }
        }

        function nextPage() {
            currentPage++;
            loadMessages();
        }

        function likeMessage(messageId) {
            fetch(`${apiBaseUrl}/message/like`, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ message_id: messageId })
            })
            .then(() => {
                document.getElementById("message").value = "";
                loadMessages();
            })
        }

        function toggleComments(messageId) {
            const commentSection = document.getElementById(`comments-${messageId}`);
            const commentForm = document.getElementById(`comment-form-${messageId}`);
            
            if (commentSection.style.display === "none") {
                loadComments(messageId);
                commentSection.style.display = "block";
                commentForm.style.display = "block";
            } else {
                commentSection.style.display = "none";
                commentForm.style.display = "none";
            }
        }

        function loadComments(messageId) {
            fetch(`${apiBaseUrl}/comments?message_id=${messageId}`)
                .then(response => response.json())
                .then(dataPaginate => {
                    const commentsContainer = document.getElementById(`comments-${messageId}`);
                    commentsContainer.innerHTML = "";
                    
                    dataPaginate.data.forEach(comment => {
                        const commentDiv = document.createElement("div");
                        commentDiv.innerHTML = `<p><strong>${comment.username}</strong>: ${comment.content}</p>`;
                        commentsContainer.appendChild(commentDiv);
                    });
                })
                .catch(error => console.error("Erreur chargement commentaires:", error));
        }

        function sendComment(messageId) {
            const username = document.getElementById(`comment-username-${messageId}`).value;
            const content = document.getElementById(`comment-content-${messageId}`).value;

            fetch(`${apiBaseUrl}/comment`, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ message_id: messageId, username, content })
            })
            .then(() => {
                loadComments(messageId);
            })
            .catch(error => console.error("Erreur envoi commentaire:", error));
        }
    </script>
</body>
</html>