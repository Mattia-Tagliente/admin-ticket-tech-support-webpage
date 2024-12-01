<div class=header-container>
    <menu class="header-menu">
        <li class="header-menu-li">
            <a href="./customers-list.php" class="header-menu-link">Clienti</a>
        </li class="header-menu-li">
        <li>
            <a href="./tickets.php" class="header-menu-link">Tickets</a>
        </li>
        <?php
            if(isset($_SESSION['admin'])){
                echo "
                <li>
                    <a href='./logout.php' class='header-menu-link'>Esci</a>
                </li>
                "
                ;
            }
        ?>
    </menu>
</div>