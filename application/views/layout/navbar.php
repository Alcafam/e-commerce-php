<nav class="navbar navbar-expand-lg bg-primary fixed-top p-0 navbar-fixed-top">
    <div class="container-fluid">
        <ul class="navbar-nav justify-content-start ">
            <li class="nav-item px-3 py-2">
                <a href="/" class="nav-link text-white px-3 m-0 p-0" aria-current="page">
                    <img class="img-fluid m-0 p-0" src="<?= base_url('assets/images/logo_white.png') ?>" width="100px" alt="DPWH Logo"/>
                </a>
            </li>
        </ul>
        <ul class="nav justify-content-end">
            <li class="px-3 py-2 fs-6 fst-italic ">
                <div>"Right Product, Right Cost, Right Quality,</div>
                <div>Right on Time, Right People"</div>
            </li>
<?php   if(isset($user_id)){
?>          <li class="nav-item">
                <a class="nav-link text-white fw-bold px-3 py-2 fs-5" href="<?= base_url('logout') ?>">Logout</a>
            </li>
<?php   }
?>
        </ul>
    </div>
</nav>