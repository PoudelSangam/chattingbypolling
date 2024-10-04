<?php
session_start();
$servername = "localhost";
$username = "";
$password = "";
$dbname = "";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['error' => "Connection failed: " . $conn->connect_error]);
    exit();
}

$user_id = mysqli_real_escape_string($conn, $_GET['user_id'] ?? '');

// Fetch incoming user details
$sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$user_id}");
$row = mysqli_fetch_assoc($sql) ?: [];

// Fetch outgoing user details (logged-in user)
$outgoing_id = $_SESSION['unique_id'];
$sql1 = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$outgoing_id}");
$row1 = mysqli_fetch_assoc($sql1) ?: [];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messenger Chat</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .chat-container {
            display: flex;
            flex-direction: column;
            height: 90vh;
            width: 100%;
            background-color: #f1f1f1;
        }
        .chat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem;
            background-color: #3b82f6;
            color: white;
        }
        .chat-box {
            flex-grow: 1;
            padding: 1rem;
            overflow-y: auto;
            background-color: white;
        }
        .chat-box::-webkit-scrollbar {
            display: none;
        }
        .chat-message {
            display: flex;
            margin-bottom: 1rem;
            max-width: 70%;
        }
        .chat-message.outgoing {
            justify-content: flex-end;
            margin-left: auto;
        }
        .chat-message img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 0.5rem;
        }
        .chat-message .message-content {
            padding: 0.5rem 1rem;
            background-color: #3b82f6;
            color: white;
            border-radius: 1rem;
        }
        .chat-message.outgoing .message-content {
            background-color: #4CAF50;
        }
        .chat-footer {
    display: flex;
    padding: 1rem;
    background-color: #f1f1f1;
    border-top: 1px solid #ddd;
    position: relative; /* Changed from fixed to relative */
    z-index: 10; /* Ensure it's above other elements */
}

        .chat-footer input {
            flex-grow: 1;
            padding: 0.75rem;
            border-radius: 1.5rem;
            border: 1px solid #ccc;
            outline: none;
        }
        .chat-footer button {
            padding: 0.75rem 1rem;
            margin-left: 0.5rem;
            background-color: #3b82f6;
            color: white;
            border-radius: 1.5rem;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body class="bg-gray-100">

    <div class="chat-container">
        <!-- Chat Header -->
    <header class="flex items-center justify-between p-4 border-b border-gray-700 bg-gray-800">
        <a href="users.php" class="text-gray-400 hover:text-gray-300">
            <i class="fas fa-arrow-left"></i>
        </a>
        <img class="w-10 h-10 rounded-full border-2 border-blue-500" src="./php/images/<?php echo !empty($row['img']) ? htmlspecialchars($row['img']) : 'default.png'; ?>" alt="">
        <div class="details flex-grow flex flex-col justify-center ml-4">
            <span class="text-lg font-semibold"><?php echo htmlspecialchars($row['fname'] . ' ' . $row['lname'] ?? ''); ?></span>
            <p class="text-gray-400"><?php echo htmlspecialchars($row['status'] ?? ''); ?></p>
        </div>
    </header>
        </header>

        <!-- Chat Box -->
        <div class="chat-box " id="messageDiv">
            <!-- Messages will be loaded dynamically here -->
        </div>

        <!-- Chat Footer -->
<footer class="chat-footer   bottom-0 left-0 right-0 bg-gray-100 p-3">
    <input type="hidden" name="outgoing_id" value="<?php echo $_SESSION['unique_id']; ?>">
    <input type="hidden" name="incoming_id" value="<?php echo $user_id; ?>">
    <input type="text" id="messageInput" placeholder="Type a message..." class="input-field flex-grow p-2 rounded-l-lg focus:outline-none">
    <button id="sendBtn" class="bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-r-lg">
        <i class="fab fa-telegram-plane"></i>
    </button>
</footer>

        
    </div>
    <script>

   const chatBox = document.getElementById('messageDiv');
const inputField = document.getElementById('messageInput');
const sendBtn = document.getElementById('sendBtn');
const outgoingInput = document.querySelector('input[name="outgoing_id"]').value;
const incomingInput = document.querySelector('input[name="incoming_id"]').value;
let lastMessageId = 0;

// Function to send a message
function sendMessage() {
    const message = inputField.value.trim();
    if (message) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "insertMessage.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                inputField.value = ''; // Clear input field
                //scrollToBottom(); // Scroll to bottom after sending message
            } else if (xhr.readyState === 4) {
                console.error("Error sending message:", xhr.status, xhr.statusText);
            }
        };
        xhr.send(`outgoing_id=${outgoingInput}&incoming_id=${incomingInput}&message=${encodeURIComponent(message)}`);
    }
}

// Function to fetch messages
function fetchMessages() {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", `fetchMessages.php?outgoing_id=${outgoingInput}&incoming_id=${incomingInput}&last_message_id=${lastMessageId}`, true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            try {
                const messages = JSON.parse(xhr.responseText);
                if (messages.length > 0) {
                    messages.forEach(msg => {
                        displayMessage(msg.msg, msg.outgoing_msg_id, msg.incoming_msg_id);
                        lastMessageId = msg.msg_id; // Update the last message ID
                    });
                }
            } catch (error) {
                console.error("Error parsing JSON response:", error, xhr.responseText);
            }
        }
    };
    xhr.send();
}

// Function to display a message in the chatbox
function displayMessage(msg, outgoingId, incomingId) {
    const isOutgoing = outgoingId == outgoingInput;
    const messageDiv = document.createElement('div');
    messageDiv.className = `chat-message ${isOutgoing ? 'outgoing' : 'incoming'}`;

    messageDiv.innerHTML = `
        ${isOutgoing ? `
            <div class="message-content">${msg}</div>
            <img src="./php/images/<?php echo htmlspecialchars($row1['img']); ?>" alt="Outgoing User Image">
        ` : `
            <img src="./php/images/<?php echo htmlspecialchars($row['img']); ?>" alt="Incoming User Image">
            <div class="message-content">${msg}</div>
        `}
    `;

    chatBox.appendChild(messageDiv);
    // scrollToBottom(); // Scroll to bottom after displaying new messages
}

// Function to scroll chatbox to the bottom
function scrollToBottom() {
    chatBox.scrollTop = chatBox.scrollHeight; // Scroll to bottom
    const footer = document.querySelector('.chat-footer');
    footer.scrollIntoView({ behavior: 'smooth', block: 'end' }); // Ensure the input area is in view
}

// Event listeners for both desktop and mobile
sendBtn.addEventListener('click', (event) => {
    event.preventDefault(); // Prevent page reload
    sendMessage();
});

// Touch event for mobile devices
sendBtn.addEventListener('touchstart', (event) => {
    event.preventDefault(); // Prevent touch event default behavior
    sendMessage();
});

// Send message when Enter key is pressed
inputField.addEventListener('keypress', (event) => {
    if (event.key === 'Enter') {
        event.preventDefault();
        sendMessage();
    }
});

// Ensure the input field remains visible when keyboard is opened (for mobile)
inputField.addEventListener('focus', () => {
    setTimeout(scrollToBottom, 300); // Wait for keyboard to fully open
});

// Fetch messages at regular intervals
window.onload = () => {
    setInterval(fetchMessages, 500); // Fetch messages every 500 ms
    scrollToBottom(); // Scroll to bottom on page load
};
</script>



</body>
</html>
