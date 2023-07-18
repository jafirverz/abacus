<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Abacus Simulator</title>
    <script src='abacus.js'></script>
    <script type="text/javascript">
      function run() {
        var abacus = new Abacus("myAbacus", 0);
        abacus.init();
      }
    </script>
  </head>
  <body onload="run();">
    <h1>Japanese Abacus Simulator (Soroban)</h1>
    <div id="myAbacus"> </div>

    <p> The JavaScript source code can be found here: <a href="abacus.js">abacus.js</a>.</p>
    <p> This website is part of the lecture <a href="https://www.uni-marburg.de/de/fb12/arbeitsgruppen/grafikmultimedia/lehre/ti">Technical Computer Science</a>.  </p>
    <p> Keywords: abacus simulator, abacus simulation, virtual abacus, online abacus, interactive abacus, soroban, html5, javascript</p>
  </body>
</html>
