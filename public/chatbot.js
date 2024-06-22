// scripts.js
function toggleChat() {
    var chatPopup = document.getElementById("chatPopup");
    if (chatPopup.style.display === "none" || chatPopup.style.display === "") {
        chatPopup.style.display = "block";
    } else {
        chatPopup.style.display = "none";
    }
}

function sendMessage() {
    var userInput = document.getElementById("userInput").value;
    if (userInput.trim() !== "") {
        var chatBody = document.getElementById("chatBody");
        
        // Adiciona a mensagem do usuário
        var userMessage = document.createElement("div");
        userMessage.className = "user-message";
        userMessage.innerText = userInput;
        chatBody.appendChild(userMessage);

        // Limpa o input
        document.getElementById("userInput").value = "";

        // Envia a mensagem para o backend
        fetch('/chat-response', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ message: userInput })
        })
        .then(response => response.json())
        .then(data => {
            var botMessage = document.createElement("div");
            botMessage.className = "bot-message";
            botMessage.innerText = data.response;
            chatBody.appendChild(botMessage);
            chatBody.scrollTop = chatBody.scrollHeight;
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
}
