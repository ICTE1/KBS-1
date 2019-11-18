<main role="main">
    <section class="jumbotron text-center landing-ad">
        <div class="container transparent-background">
            <h1 class="jumbotron-heading white-text halloween-font">Tijd voor halloween</h1>
            <p><a href="#" class="btn btn-light my-2 halloween-font">Ga naar de aanbieding</a></p>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row text-center">
                <?php for($i =0; $i < 4; $i++): ?>
                <div class="col-md-3">
                    <div class="card">
                        <img src="..." class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Titel - korting</h5>
                            <h5 class="card-title">Prijs</h5>
                            <a href="#" class="btn btn-primary">Bekijk product</a>
                        </div>
                    </div>
                </div>
                <?php endfor; ?>
            </div>
        </div>
    </section>

    <section class="jumbotron text-center feelinglucky">
        <div class="container transparent-background">
            <h1 class="jumbotron-heading white-text">I'm feeling lucky</h1>
            <p><a href="#" class="btn btn-light my-2">GO</a></p>
        </div>
    </section>
</main>

