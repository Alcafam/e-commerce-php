
    
    <div class="login-container">
        <div class="container-content p-5">
            <h3 class="text-white">REGISTRATION</h3>
<?php       if($this->session->flashdata('input_errors')){
?>          <div class="alert alert-danger fs-5" role="alert"><?=$this->session->flashdata('input_errors')?></div>
<?php       }
?>
            <form class="mt-3 text-center" action="<?= base_url('registration/registration_process')?>" method="POST">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
                <input type="email" name="email" class="form-control mb-2" placeholder="Email Address">     
                <input type="text" name="first_name" class="form-control mb-2" placeholder="First Name">     
                <input type="text" name="last_name" class="form-control mb-2" placeholder="Last Name">         
                <input type="password" name="password" class="form-control mb-2" placeholder="Password">
                <input type="password" name="confirm_password" class="form-control mb-2" placeholder="Confirm Password">

                <input type="submit" class="form-button w-25 mb-3" value="Register">
            </form>
            <a class="text-center d-block" href="<?=base_url('login') ?>">Already have an account? Login</a>
        </div>
    </div> 
</body>
</html>