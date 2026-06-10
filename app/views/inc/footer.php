                </div> <!-- End Content Area -->
                <footer style="padding: 1.5rem; color: var(--text-gray); font-size: 0.85rem; font-weight: 600; text-align: center; border-top: 1px solid #e2e8f0;">
                    &copy; <?php echo date('Y'); ?> <strong><?php echo SITENAME; ?></strong>. All rights reserved.
                </footer>
            </div> <!-- End Main Wrapper -->
        </div> <!-- End App Container -->

        <!-- Chatbot Floating Widget (Light & Compact Theme) -->
        <div id="smartChatbot" class="chatbot-container">
            
            <!-- Chatbot Toggle Button -->
            <button class="chatbot-toggler" id="chatbotToggler" onclick="toggleChatbot()">
                <i class="fas fa-comment-dots toggle-icon-open"></i>
                <i class="fas fa-times toggle-icon-close" style="display:none;"></i>
            </button>

            <!-- Chatbot Window -->
            <div class="chatbot-window" id="chatbotWindow">
                <div class="chatbot-header">
                    <div class="bot-info">
                        <div class="bot-avatar">
                            <img src="https://cdn-icons-png.flaticon.com/512/4712/4712010.png" alt="bot">
                            <div class="online-dot"></div>
                        </div>
                        <div>
                            <h4>Trợ Lý Ảo TD-Bot</h4>
                            <span class="status">Trực tuyến</span>
                        </div>
                    </div>
                    <button class="close-btn" onclick="toggleChatbot()"><i class="fas fa-chevron-down"></i></button>
                </div>
                
                <?php if (!isset($_SESSION['user_id'])) : ?>
                    <!-- Locked View (Not logged in) -->
                    <div class="chatbot-locked-view">
                        <div class="lock-illustration">
                            <i class="fas fa-lock"></i>
                        </div>
                        <h3>Đăng nhập để chat</h3>
                        <p>Bạn cần đăng nhập tài khoản để sử dụng tính năng tra cứu và hỏi đáp.</p>
                        
                        <a href="<?php echo URLROOT; ?>/users/login" class="btn-chat-login">
                            Đăng Nhập
                        </a>
                    </div>
                <?php else : ?>
                    <!-- Active Chat View (Logged in) -->
                    <div class="chatbot-messages" id="chatbotMessages">
                        <div class="message bot-message">
                            <div class="msg-bubble">Chào bạn! 🎓<br>Mình là TD-Bot. Mình có thể giúp bạn xem <b>học phí</b>, <b>điểm số</b> và <b>lịch học</b>. Bạn muốn hỏi gì nào?</div>
                        </div>
                    </div>
                    <div class="chatbot-input">
                        <input type="text" id="chatInput" placeholder="Nhập câu hỏi..." onkeypress="handleChatKeyPress(event)" autocomplete="off">
                        <button class="send-btn" onclick="sendChatMessage()"><i class="fas fa-paper-plane"></i></button>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <style>
        .chatbot-container {
            position: fixed;
            bottom: 25px;
            right: 25px;
            z-index: 9999;
            font-family: 'Inter', sans-serif;
            display: flex;
            align-items: flex-end;
            flex-direction: column;
            gap: 15px;
        }

        .chatbot-tooltip {
            background: #ffffff;
            color: #1e293b;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            display: flex;
            align-items: center;
            gap: 6px;
            transition: opacity 0.3s, transform 0.3s;
            border: 1px solid #f1f5f9;
        }

        .wave {
            animation: wave-animation 2.5s infinite;
            transform-origin: 70% 70%;
            display: inline-block;
        }
        @keyframes wave-animation {
            0% { transform: rotate(0.0deg) }
            10% { transform: rotate(14.0deg) }
            20% { transform: rotate(-8.0deg) }
            30% { transform: rotate(14.0deg) }
            40% { transform: rotate(-4.0deg) }
            50% { transform: rotate(10.0deg) }
            60% { transform: rotate(0.0deg) }
            100% { transform: rotate(0.0deg) }
        }

        .chatbot-toggler {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            border: none;
            border-radius: 50%;
            font-size: 1.25rem;
            cursor: pointer;
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.3);
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            display: flex;
            align-items: center;
            justify-content: center;
            align-self: flex-end;
        }

        .chatbot-toggler:hover {
            transform: scale(1.1);
        }

        .chatbot-window {
            position: absolute;
            bottom: 75px;
            right: 0;
            width: 320px;
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.12);
            overflow: hidden;
            display: none;
            flex-direction: column;
            border: 1px solid #e2e8f0;
            animation: slideUp 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px) scale(0.9); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .chatbot-window.active {
            display: flex;
        }

        .chatbot-header {
            background: #ffffff;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #f1f5f9;
        }

        .bot-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .bot-avatar {
            width: 36px;
            height: 36px;
            background: #f8fafc;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            padding: 4px;
        }

        .bot-avatar img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .online-dot {
            position: absolute;
            bottom: -2px;
            right: -2px;
            width: 10px;
            height: 10px;
            background: #10b981;
            border: 2px solid #ffffff;
            border-radius: 50%;
        }

        .bot-info h4 {
            margin: 0 0 0.1rem 0;
            font-size: 0.95rem;
            font-weight: 700;
            color: #0f172a;
        }

        .bot-info .status {
            font-size: 0.75rem;
            color: #10b981;
            font-weight: 600;
        }

        .close-btn {
            background: #f1f5f9;
            border: none;
            color: #64748b;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.2s;
        }
        .close-btn:hover { background: #e2e8f0; color: #0f172a; }

        /* Locked View Styles */
        .chatbot-locked-view {
            padding: 3rem 1.5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            background: #f8fafc;
        }

        .lock-illustration {
            width: 64px;
            height: 64px;
            background: #ffffff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: #a855f7;
            margin-bottom: 1rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .chatbot-locked-view h3 {
            color: #0f172a;
            font-size: 1.1rem;
            font-weight: 700;
            margin: 0 0 0.5rem 0;
        }

        .chatbot-locked-view p {
            color: #64748b;
            font-size: 0.85rem;
            line-height: 1.5;
            margin: 0 0 1.5rem 0;
        }

        .btn-chat-login {
            width: 100%;
            padding: 0.75rem;
            border-radius: 10px;
            font-size: 0.9rem;
            font-weight: 600;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            text-decoration: none;
            transition: all 0.2s;
            border: none;
        }

        .btn-chat-login:hover { transform: translateY(-2px); box-shadow: 0 4px 10px rgba(99, 102, 241, 0.2); }

        /* Chat View Styles */
        .chatbot-messages {
            height: 280px;
            padding: 1rem;
            overflow-y: auto;
            background: #f8fafc;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        /* Scrollbar */
        .chatbot-messages::-webkit-scrollbar { width: 4px; }
        .chatbot-messages::-webkit-scrollbar-track { background: transparent; }
        .chatbot-messages::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }

        .message {
            display: flex;
            max-width: 85%;
        }

        .bot-message { align-self: flex-start; }
        .user-message { align-self: flex-end; }

        .msg-bubble {
            padding: 0.7rem 0.9rem;
            border-radius: 14px;
            font-size: 0.85rem;
            line-height: 1.4;
        }

        .bot-message .msg-bubble {
            background: #ffffff;
            color: #334155;
            border-bottom-left-radius: 4px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            border: 1px solid #f1f5f9;
        }

        .user-message .msg-bubble {
            background: #6366f1;
            color: white;
            border-bottom-right-radius: 4px;
        }

        .chatbot-input {
            display: flex;
            padding: 0.75rem;
            background: #ffffff;
            border-top: 1px solid #f1f5f9;
            gap: 0.5rem;
        }

        .chatbot-input input {
            flex: 1;
            padding: 0.6rem 1rem;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            color: #0f172a;
            border-radius: 50px;
            outline: none;
            font-size: 0.85rem;
            transition: all 0.2s;
        }

        .chatbot-input input::placeholder { color: #94a3b8; }
        .chatbot-input input:focus { border-color: #6366f1; background: #ffffff; box-shadow: 0 0 0 2px rgba(99,102,241,0.1); }

        .send-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #6366f1;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
            flex-shrink: 0;
        }
        .send-btn:hover { background: #4f46e5; }
        
        .typing-indicator {
            display: none;
            padding: 0.6rem 0.9rem;
            background: #ffffff;
            border-radius: 14px;
            border-bottom-left-radius: 4px;
            align-self: flex-start;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            border: 1px solid #f1f5f9;
        }
        .typing-indicator span {
            display: inline-block;
            width: 5px; height: 5px;
            background: #94a3b8;
            border-radius: 50%;
            margin: 0 2px;
            animation: bounce 1.4s infinite ease-in-out both;
        }
        .typing-indicator span:nth-child(1) { animation-delay: -0.32s; }
        .typing-indicator span:nth-child(2) { animation-delay: -0.16s; }
        </style>

        <script>
        const IS_LOGGED_IN = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;

        function toggleChatbot() {
            const window = document.getElementById('chatbotWindow');
            const iconOpen = document.querySelector('.toggle-icon-open');
            const iconClose = document.querySelector('.toggle-icon-close');

            window.classList.toggle('active');
            
            if (window.classList.contains('active')) {
                iconOpen.style.display = 'none';
                iconClose.style.display = 'block';
            } else {
                iconOpen.style.display = 'block';
                iconClose.style.display = 'none';
            }
        }

        function handleChatKeyPress(e) {
            if (e.key === 'Enter') sendChatMessage();
        }

        function sendChatMessage() {
            const input = document.getElementById('chatInput');
            if(!input) return;
            const message = input.value.trim();
            if (!message) return;

            addMessage(message, 'user');
            input.value = '';

            showTypingIndicator();

            setTimeout(() => {
                hideTypingIndicator();
                const response = getBotResponse(message.toLowerCase());
                addMessage(response, 'bot');
            }, 800);
        }

        function addMessage(text, sender) {
            const messagesContainer = document.getElementById('chatbotMessages');
            if(!messagesContainer) return;
            const msgDiv = document.createElement('div');
            msgDiv.className = `message ${sender}-message`;
            msgDiv.innerHTML = `<div class="msg-bubble">${text}</div>`;
            messagesContainer.appendChild(msgDiv);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        function showTypingIndicator() {
            const messagesContainer = document.getElementById('chatbotMessages');
            if(!messagesContainer) return;
            const typingDiv = document.createElement('div');
            typingDiv.className = 'message bot-message typing-indicator';
            typingDiv.id = 'typingIndicator';
            typingDiv.style.display = 'block';
            typingDiv.innerHTML = `<span></span><span></span><span></span>`;
            messagesContainer.appendChild(typingDiv);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        function hideTypingIndicator() {
            const typingDiv = document.getElementById('typingIndicator');
            if (typingDiv) typingDiv.remove();
        }

        function getBotResponse(msg) {
            if (msg.includes('học phí') || msg.includes('đóng tiền')) {
                return 'Học phí có thể xem tại trang <b>Thông tin của tôi</b>. Nếu bạn đã đóng nhưng hệ thống chưa cập nhật, vui lòng đợi 24h nhé.';
            } else if (msg.includes('điểm') || msg.includes('thi') || msg.includes('kết quả')) {
                return 'Bạn có thể xem điểm tại mục <b>Xem điểm</b> trên thanh công cụ bên trái. Chúc bạn có điểm cao!';
            } else if (msg.includes('xin chào') || msg.includes('hi ') || msg.includes('chào') || msg.includes('hello')) {
                return 'Chào bạn! Mình có thể hỗ trợ giải đáp nhanh về <b>học vụ</b>, <b>điểm số</b> và <b>học phí</b>. Bạn cần hỏi gì nào?';
            } else {
                return 'Xin lỗi, hiện tại mình chỉ có thể trả lời các câu hỏi về Học phí, Điểm thi và Tài khoản. Bạn có thể hỏi lại được không?';
            }
        }
        </script>
    <script src="<?php echo URLROOT; ?>/js/main.js"></script>
</body>
</html>
