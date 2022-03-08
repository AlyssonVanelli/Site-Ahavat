<?php
    include_once("templates/header.php");

    require_once("dao/MovieDAO.php");
    require_once("dao/CarouselDAO.php");

    $movieDao = new MovieDAO($conn, $BASE_URL);
    $carouselDao = new CarouselDAO($conn, $BASE_URL);

    $latestMovies = $movieDao->getLatestMovies();
    $latestSlider = $carouselDao->getLatestSliders();


    $status="";
    $msg="";
    $city="";
    date_default_timezone_set('America/Sao_Paulo');
    if(isset($_POST['submit'])){
        $city=$_POST['city'];
        $url="http://api.openweathermap.org/data/2.5/weather?q=$city&appid=49c0bad2c7458f1c76bec9654081a661";
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $result=curl_exec($ch);
        curl_close($ch);
        $result=json_decode($result,true);
        if($result['cod']==200){
            $status="yes";
        }else{
            $msg=$result['message'];
        }
    }

    $urlhebcal = "https://www.hebcal.com/hebcal?v=1&cfg=json&maj=on&min=on&mod=on&nx=on&year=now&month=now&ss=on&mf=on&c=on&geo=geoname&city=BR-saopaulo&M=on&s=on";

    $ch=curl_init($urlhebcal);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
    $data = json_decode(curl_exec($ch));

    $sextaesabado = array_filter($data->items, function ($item){

        $proximosabado = strtotime("next saturday");
        $itemdate = strtotime($item->date);
        $diadasemana = date("w",$itemdate);
        return $diadasemana == 6 && $itemdate == $proximosabado;
    });
    
?>

<div id="main-container" class="container-fluid">

    <section class="noticia-destaque">
        <div class="center">
            <div class="img-destaque">
                <div class="title-destaque-descricao">
                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                        <!-- Indicators -->
                            <ol class="carousel-indicators">
                                <?php
                                    $controle_ativo = 2;		
                                    $controle_num_slide = 1;
                                    $result_carousel = "SELECT * FROM carrouses ORDER BY id ASC";
                                    $resultado_carousel = mysqli_query($conn2, $result_carousel);
                                ?>						
                            </ol>

                            <!-- Wrapper for slides -->
                            <div class="carousel-inner" role="listbox">
                            <?php
                                    $controle_ativo = 2;						
                                    $result_carousel = "SELECT * FROM carousel ORDER BY id ASC";
                                    $resultado_carousel = mysqli_query($conn2, $result_carousel);
                                    while($row_carousel = mysqli_fetch_assoc($resultado_carousel)){ 
                                        if($controle_ativo == 2){ ?>
                                            <div class="item active">
                                                <h2><?php echo $row_carousel['title']; ?></h2>
                                                <p><?php echo $row_carousel['description']; ?></p>
                                                <img src="img/slide/<?php echo $row_carousel['image']; ?>" alt="<?php echo $row_carousel['title']; ?>">
                                            </div><?php
                                            $controle_ativo = 1;
                                        }else{ ?>
                                            <div class="item">
                                                <h2><?php echo $row_carousel['title']; ?></h2>
                                                <p><?php echo $row_carousel['description']; ?></p>
                                                <img id="img_slider" src="img/slide/<?php echo $row_carousel['image']; ?>" alt="<?php echo $row_carousel['title']; ?>">
                                            </div> <?php
                                        }
                                    }
                            ?>					
                            </div>

                            <!-- Controls -->
                            <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="outras-noticias">
        <div class="title-outras-noticia">
            <div class="center">
                <div class="informacoes">
                    <h1>Informações</h1>
                    <div class="informacoes-noticias">
                        <div class="informacoes-noticia-single">
                            <div class="form">
                                <form style="width:100%;" method="post">
                                    <input type="text" class="text" placeholder="Digite o nome da cidade" name="city" value="<?php echo $city?>"/>
                                    <input type="submit" value="Buscar" class="submit" name="submit"/>
                                    <?php echo $msg?>
                                </form>
                            </div>
                            <?php if($status=="yes"){?>
                            <article class="widget">
                                <div class="weatherInfo">
                                    <div class="description">
                                    <div class="weatherCondition">Por do Sol : <?php echo $city?></div>
                                    <div class="place"><?php echo date ('H:i',$result['sys']['sunset'])?></div>
                                    </div>
                                </div>
                            </article>
                            <?php } ?>
                            <?php
                                foreach ($sextaesabado as $item){
                                if (isset($item->leyning)){
                                    $ciclo = "";
                                    foreach ($item->leyning->triennial as $trecho){
                                        $ciclo .="<li>".$trecho."</li>";
                                    }
                                    echo "<div> 
                                    <h3> ".$item->title."</h3>
                                    <small> ".$item->leyning->torah."</small>
                                    <small> ".$item->leyning->haftarah."</small>
                                    <small> ".$item->leyning->maftir."</small>
                                    <ul>".$ciclo."</ul>
                                    </div>";
                                }else if($item->category == "mevarchim"){
                                    echo "<div> 
                                    <h3> ".$item->hebrew."</h3>
                                    <h3> ".$item->title."</h3>
                                    <h3> ".$item->memo."</h3>
                                    </div>";
                                }
                                echo "<hr/>";

                                } 
                            ?>
                        </div>
                    </div>
                </div>
                <div class="ultimas">
                    <h2>Postagens</h2>

                    <?php foreach ($latestMovies as $movie): ?>
                        <?php require("templates/notice_card.php"); ?>
                    <?php endforeach; ?>

                </div>
            </div>
        </div>
    </section>

</div>

<?php
    include_once("templates/footer.php");
?>