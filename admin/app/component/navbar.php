<div class="navbar-fixed">
    <nav class="z-depth-1">
        <div class="nav-wrapper">
            <ul>
                <li><a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a></li>
                <li><a href="<?= $BASE ?>../" class="brand-logo black-text waves-effect"><b>Dashboard</b></a></li>
            </ul>
            
            
            <ul class="right waves-effect">
                <li class="nav-login">
                    <a class="waves-effect" href="<?= $BASE ?>../logout/"><i class="material-icons right">exit_to_app</i><span class="hide-on-med-and-down ">Logout</span></a>
                </li>
            </ul>
        </div>
    </nav>
</div>

<ul id="slide-out" class="sidenav sidenav-fixed z-depth-1">
    <li class="navbar-fixed"></li>
    <li><a class="subheader">Dashboard</a></li>
    <li><a class="waves-effect" href="<?= $BASE ?>../"><i class="material-icons">insights</i>Overview</a></li>
    
    <li><a class="waves-effect" href="<?= $BASE ?>../users/"><i class="material-icons">person_outline</i>Clients</a></li>

    <li><a class="waves-effect" href="<?= $BASE ?>../users/?suppliers=true"><i class="material-icons">person_outline</i>Suppliers</a></li>
    <li><a class="waves-effect" href="<?= $BASE ?>../category/"><i class="material-icons">tag</i>Categories</a></li>
    <li><a class="waves-effect" href="<?= $BASE ?>../locations/"><i class="material-icons">map</i>Locations</a></li>
    <li><a class="waves-effect" href="<?= $BASE ?>../blog/"><i class="material-icons">inbox</i>Blog</a></li>
    <li><a class="waves-effect" href="<?= $BASE ?>../library/"><i class="material-icons">photo_library</i>Images</a></li>
    <li><a class="waves-effect" href="<?= $BASE ?>../maintenance/"><i class="material-icons">tune</i>mainenance</a></li>

</ul>
