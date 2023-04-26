<?php $slide = getAllSlide($conn); ?>
<section id="slider">
    <!--slider-->
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div id="slider-carousel" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">

                        <?php foreach ($slide[0] as $key => $value) { ?>
                        <li data-target='#slider-carousel' data-slide-to='<?= $key?>'
                            <?= ($value==min($slide[0])) ? "class='active'" : "" ?>></li>
                        <?php } ?>
                    </ol>

                    <div class="carousel-inner">
                        <?php foreach ($slide[0] as $key => $value) { ?>
                        <div class="item <?= ($value==min($slide[0])) ? "active" : "" ?>">
                            <img width="100%" height="100%" src="./assets/images/slide/<?= $slide[1][$key]?>"
                                class="girl img-responsive" alt="" />
                        </div>
                        <?php }?>
                    </div>

                    <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                        <i class="fa fa-angle-left"></i>
                    </a>
                    <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                        <i class="fa fa-angle-right"></i>
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>
<!--/slider-->