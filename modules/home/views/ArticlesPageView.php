<?php

class ArticlesPageView extends View {

    public function blogShow() {
        ?>



        <?php
        return ob_get_clean();
    }

    public function diyShow() {
        ?>



        <?php
        return ob_get_clean();
    }
}
