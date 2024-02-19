
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
</body>
</html>