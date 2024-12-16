<div id="userModal" class="modal">
    <div class="popup-container">
        <span class="close-btn">&times;</span>
        <h2 id="modalTitle">Rất nhiều đặc quyền và quyền lợi mua sắm đang chờ bạn</h2>
        <div class="benefits">
            <div class="benefit-item"> <img src="assets/images/icons/discount.png" alt="Voucher ưu đãi">
                <p>Voucher ưu đãi</p>
            </div>
            <div class="benefit-item"> <img src="assets/images/icons/gift.png" alt="Quà tặng độc quyền">
                <p>Quà tặng độc quyền</p>
            </div>
            <div class="benefit-item"> <img src="assets/images/icons/refund.png" alt="Hoàn tiền">
                <p>Hoàn tiền </p>
            </div>
        </div>
        <div class="login-options">
            <button><img src="assets/images/icons/gg.png" alt="Google">
            </button> <button><img src="assets/images/icons/fc.png" alt="Facebook"></button>
        </div>
        <form id="loginForm" class="login-form active" action="module/auth/login.php" method="POST">
            <input type="text" placeholder="Tên tài khoản của bạn" name="username" required>
            <input type="password" placeholder="Mật khẩu" name="password" required>
            <button type="submit">ĐĂNG NHẬP</button>
            <div class="links">
                <a href="#" id="switchToRegister">Đăng ký</a>
                <a href="module/auth/forgot_password.php">Quên mật khẩu</a>
            </div>
        </form>
        <form id="registerForm" class="register-form" action="module/auth/register.php" method="POST">
            <input type="text" placeholder="Tên của bạn" name="username" required>
            <input type="text" placeholder="SĐT của bạn" name="phone" required>
            <input type="email" placeholder="Email của bạn" name="email" required>
            <input type="password" placeholder="Mật khẩu" name="password" required>
            <button type="submit">ĐĂNG KÝ TÀI KHOẢN</button>
            <div class="links">
                <a href="#" id="switchToLogin">Đăng nhập</a>
                <a href="module/auth/forgot_password.php">Quên mật khẩu</a>
            </div>
        </form>
        <?php if (isset($_SESSION['error'])) {
            echo '<p style="color:red;">' . htmlspecialchars($_SESSION['error']) . '</p>';
            unset($_SESSION['error']);
        }
        if (isset($_SESSION['success'])) {
            echo '<p style="color:green;">' . htmlspecialchars($_SESSION['success']) . '</p>';
            unset($_SESSION['success']);
        } ?>
    </div>
</div>