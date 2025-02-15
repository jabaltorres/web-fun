<div id="hero" class="jumbotron jumbotron-fluid px-4 bg-dark text-white">
  <div class="container">
    <h1 class="display-4"><?= $settingsManager->getSetting('site_name'); ?></h1>
    <p class="lead"><?= $settingsManager->getSetting('site_tagline'); ?></p>
    
    <a href="https://github.com/jabaltorres/web-fun/wiki" class="btn btn-secondary" target="_blank">Github Wiki</a>
  </div>
</div>

<div id="content" class="content">
  <div class="row">
    <div class="col-6">
      <h3>Records</h3>
      <p>Bacon ipsum dolor amet turducken jowl flank strip steak pork shank.</p>
      <a href="/" class="btn btn-primary">Records</a>
    </div>

    <div class="col-6">
      <h3>Demos</h3>
      <p>Bacon ipsum dolor amet turducken jowl flank strip steak pork shank.</p>
      <a href="/sandbox/" class="btn btn-primary">Sandbox</a>
    </div>

  </div>
</div>
