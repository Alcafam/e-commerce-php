
    <div class="login-container">
        <div class="container-content p-5">
            <h3 class="text-white">LOGIN</h3>
<?php       if($this->session->flashdata('input_errors')){
?>          <div class="alert alert-danger fs-5" role="alert"><?=$this->session->flashdata('input_errors')?></div>
<?php       }
?>
            <form class="mt-3 text-center" action="<?= base_url('login/login_process')?>" method="POST">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
                <input type="text" name="email" class="form-control mb-2" placeholder="Email Address">
                <input type="password" name="password" class="form-control mb-2" placeholder="Password">

                <input type="submit" class="form-button w-25 mb-3" value="Login">
            </form>
            <a class="d-block text-center" href="<?=base_url('registration') ?>">New member? Register here</a>
        </div>
    </div> 

    <div class="bg-warning container mt-5 p-3 rounded">
    <b>Note:</b><br>
    For testing purposes, you can use the following accounts:
    <ul class="mt-2">
        <li><b>Admin Account</b><br>
            Email: <code>admin@example.com</code><br>
            Password: <code>12345678</code>
        </li>
        <li class="mt-2"><b>User Account 1</b><br>
            Email: <code>user1@example.com</code><br>
            Password: <code>12345678</code>
        </li>
        <li class="mt-2"><b>User Account 2</b><br>
            Email: <code>user2@example.com</code><br>
            Password: <code>12345678</code>
        </li>
    </ul>
</div>
</body>
</html>