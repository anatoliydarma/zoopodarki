<div>

  <script src="//api-maps.yandex.ru/2.1/?lang=ru_RU&apikey=cd408cfa-b066-4543-8d65-dc5be38d9c48" type="text/javascript">
  </script>
  <div id="zones" style="height: 400px;" class="w-full max-h-full"></div>
  <script>
    ymaps.ready(init);

    var mapZones;
    var poligons = new Array();

    var coordinates = {
      '1500': [
        [59.932934149, 30.462325868],
        [59.933428903, 30.4695977],
        [59.933149622, 30.476869532],
        [59.931709253, 30.48371221],
        [59.929494709, 30.489009937],
        [59.926601165, 30.493811625],
        [59.922588979, 30.496896699],
        [59.918134129, 30.496972868],
        [59.914386198, 30.494550286],
        [59.910010267, 30.488762787],
        [59.907183081, 30.479198738],
        [59.906464515, 30.467746414],
        [59.907983812, 30.457839042],
        [59.911318637, 30.449611111],
        [59.913722821, 30.446095006],
        [59.91655707, 30.444123854],
        [59.920404742, 30.443352855],
        [59.9237358, 30.444298469],
        [59.926831325, 30.447088705],
        [59.92958251, 30.451252232],
        [59.931559402, 30.456531558],
      ],
      '10000': [
        [59.985913647, 30.348686036],
        [59.99326527, 30.366699172],
        [59.999756959, 30.387115568],
        [60.004316491, 30.408905254],
        [60.008017307, 30.432068231],
        [60.009358117, 30.454716224],
        [60.009755027, 30.475304281],
        [59.995647817, 30.4787262],
        [59.989493477, 30.48541534],
        [59.984024976, 30.495194384],
        [59.979881501, 30.524096709],
        [59.971614357, 30.548192515],
        [59.966368438, 30.553701483],
        [59.959059266, 30.553717286],
        [59.949938015, 30.54344921],
        [59.939266503, 30.539360944],
        [59.932725407, 30.537316811],
        [59.92790342, 30.532526096],
        [59.918093531, 30.526336625],
        [59.897606524, 30.526326963],
        [59.891404592, 30.523399059],
        [59.88421283, 30.526701125],
        [59.872539431, 30.532234789],
        [59.866615018, 30.530838832],
        [59.861896214, 30.521889776],
        [59.856142313, 30.510537459],
        [59.854127089, 30.50468964],
        [59.853835981, 30.49884182],
        [59.853493434, 30.480394295],
        [59.849529808, 30.46572332],
        [59.8461676, 30.458708179],
        [59.840390294, 30.454439621],
        [59.834870763, 30.44862611],
        [59.830989466, 30.444014229],
        [59.832736938, 30.427514797],
        [59.835174389, 30.411015365],
        [59.838646666, 30.393829288],
        [59.841245103, 30.384377943],
        [59.844015808, 30.374926597],
        [59.852875236, 30.351004246],
        [59.867765003, 30.32382033],
        [59.886523955, 30.303502868],
        [59.90510017, 30.293313427],
        [59.917482137, 30.291222781],
        [59.929515434, 30.291535394],
        [59.940168621, 30.295624558],
        [59.949786873, 30.301087012],
        [59.960605416, 30.310926831],
        [59.970733182, 30.322139942],
        [59.978796659, 30.334898005],
      ],
      '15000': [
        [59.983595151, 30.233157929],
        [60.001387713, 30.255107969],
        [60.015224552, 30.279289606],
        [60.028026522, 30.309221899],
        [60.037737298, 30.339154192],
        [60.047102389, 30.380501967],
        [60.051323375, 30.409661784],
        [60.046716929, 30.429208564],
        [60.040898946, 30.438295308],
        [60.03576046, 30.440950405],
        [60.032336154, 30.443948825],
        [60.02519636, 30.450727034],
        [60.018569722, 30.458535212],
        [60.013400318, 30.471321569],
        [60.006857128, 30.476898148],
        [60.001310702, 30.476896941],
        [59.995763346, 30.477925701],
        [59.99133117, 30.482559351],
        [59.987241858, 30.488222968],
        [59.98266869, 30.502125125],
        [59.981014938, 30.520147154],
        [59.973411271, 30.543998424],
        [59.969694692, 30.550602556],
        [59.965462178, 30.553430138],
        [59.962170479, 30.553854686],
        [59.95948001, 30.553249266],
        [59.955129796, 30.549635167],
        [59.945911833, 30.541376999],
        [59.931768877, 30.536876961],
        [59.923189647, 30.528962116],
        [59.916329198, 30.52585379],
        [59.898643977, 30.525816948],
        [59.892989565, 30.524583501],
        [59.887334191, 30.525066667],
        [59.876365162, 30.530324536],
        [59.872760744, 30.532196902],
        [59.869155936, 30.531322686],
        [59.865047792, 30.527514319],
        [59.858381581, 30.513374451],
        [59.855831235, 30.509002635],
        [59.853970375, 30.503257528],
        [59.853352081, 30.48009434],
        [59.850391131, 30.466726949],
        [59.846740101, 30.460569336],
        [59.838705097, 30.453370656],
        [59.83204844, 30.444112039],
        [59.824599057, 30.434349537],
        [59.821290375, 30.418407225],
        [59.816743427, 30.387895892],
        [59.814785284, 30.353264686],
        [59.809490222, 30.333545824],
        [59.807302351, 30.323439999],
        [59.808481274, 30.319461126],
        [59.809660155, 30.315997238],
        [59.812449379, 30.308554477],
        [59.819623683, 30.290664882],
        [59.827961199, 30.273891085],
        [59.836641647, 30.259177225],
        [59.845664757, 30.24643747],
        [59.855375075, 30.234041039],
        [59.864996379, 30.22456285],
        [59.875476448, 30.216457953],
        [59.88778335, 30.208825125],
        [59.900602231, 30.203938878],
        [59.914276707, 30.20128423],
        [59.927945553, 30.201719486],
        [59.930917057, 30.196688425],
        [59.937672174, 30.196463882],
        [59.941721626, 30.190521633],
        [59.951882044, 30.196146594],
        [59.957414956, 30.206709872],
        [59.960222694, 30.210454998],
        [59.963030194, 30.215230093],
        [59.967957178, 30.212592325],
        [59.974888617, 30.210406694],
        [59.977795524, 30.215579519],
        [59.980530413, 30.221782312],
      ],
      '30000': [
        [59.920246038, 30.526355561],
        [59.903690554, 30.52674064],
        [59.887471304, 30.524722459],
        [59.878583408, 30.530408163],
        [59.873363147, 30.53273603],
        [59.86900378, 30.531287348],
        [59.866065809, 30.529495342],
        [59.86261046, 30.522896818],
        [59.854836627, 30.508326479],
        [59.852174993, 30.474336367],
        [59.8476539, 30.460688708],
        [59.84054497, 30.455280795],
        [59.826840237, 30.437941836],
        [59.820034355, 30.414079746],
        [59.817142665, 30.392812777],
        [59.815113835, 30.369829195],
        [59.814379584, 30.353025422],
        [59.810387118, 30.340675324],
        [59.809847296, 30.327295258],
        [59.820979965, 30.301927459],
        [59.833834189, 30.277932951],
        [59.83304674, 30.264016443],
        [59.828635922, 30.244606771],
        [59.823879373, 30.226055406],
        [59.818604343, 30.214370495],
        [59.812681112, 30.201054802],
        [59.809174026, 30.18293259],
        [59.801176878, 30.17116185],
        [59.798359415, 30.157331172],
        [59.812042396, 30.115226389],
        [59.814393869, 30.070141404],
        [59.813292767, 30.024369774],
        [59.820780298, 29.990725663],
        [59.820554059, 29.963947247],
        [59.815840101, 29.937168831],
        [59.812074985, 29.919145146],
        [59.811417093, 29.896314942],
        [59.814589759, 29.847907952],
        [59.825269646, 29.825765152],
        [59.845270949, 29.809887234],
        [59.855784327, 29.801948275],
        [59.861812859, 29.789889443],
        [59.867652223, 29.767059998],
        [59.868331122, 29.74380064],
        [59.873835196, 29.721914574],
        [59.881567536, 29.692690742],
        [59.893087042, 29.664840202],
        [59.906334546, 29.659154678],
        [59.917855937, 29.662395546],
        [59.94260636, 29.674370445],
        [59.978999858, 29.688363884],
        [59.99838333, 29.699480476],
        [60.014667061, 29.720896751],
        [60.021513664, 29.735022002],
        [60.021154468, 29.77867301],
        [60.029698753, 29.86528838],
        [60.035411569, 29.938342502],
        [60.038867722, 29.973152949],
        [60.04095195, 30.011053301],
        [60.059570279, 30.144801925],
        [60.063695854, 30.163280032],
        [60.070390452, 30.174548361],
        [60.077854359, 30.184615061],
        [60.082919431, 30.199144956],
        [60.085030313, 30.22345955],
        [60.088739421, 30.237505122],
        [60.092276929, 30.245714208],
        [60.095728476, 30.256326552],
        [60.098495069, 30.267968865],
        [60.0996356, 30.283988543],
        [60.098380071, 30.296231671],
        [60.095561302, 30.317802734],
        [60.094282875, 30.355509967],
        [60.091589476, 30.36904208],
        [60.086327759, 30.37708103],
        [60.070663369, 30.382859247],
        [60.062635631, 30.387507884],
        [60.056319674, 30.393529813],
        [60.0496838, 30.414843384],
        [60.047093893, 30.426701799],
        [60.043475184, 30.435813632],
        [60.02843362, 30.448029151],
        [60.018071478, 30.458613886],
        [60.015823595, 30.466839064],
        [60.012545998, 30.472660984],
        [60.006264707, 30.477109612],
        [60.000840519, 30.476408399],
        [59.996338236, 30.477938784],
        [59.992350447, 30.480499137],
        [59.986090809, 30.490083039],
        [59.982492252, 30.504473459],
        [59.980095679, 30.521953785],
        [59.975251019, 30.539176618],
        [59.972398914, 30.546243082],
        [59.969031101, 30.55124961],
        [59.96347192, 30.554367863],
        [59.95842744, 30.552679597],
        [59.949195813, 30.543123255],
        [59.933993076, 30.537743482],
        [59.926948229, 30.53307949],
      ]
    };

    function init() {
      mapZones = new ymaps.Map('zones', {
        center: [59.91995, 30.470315],
        zoom: 10,
        controls: ['zoomControl', 'fullscreenControl']
      });

      poligons[1500] = new ymaps.GeoObject({
        geometry: {
          type: "Polygon",
          coordinates: [
            coordinates[1500]
          ],
          fillRule: "nonZero"
        },
        properties: {
          hintContent: "Кликните, чтобы узнать стоимость доставки в этой зоне",
          balloonContentHeader: 'Зона 1',
          balloonContent: '<table class="table table-fixed"><tr><th class="p-1">Сумма заказа</th><th class="p-1">Стоимость доставки</th></tr><tr><td class="p-1"><b>до</b> 1000 руб.</td><td class="p-1">300 руб.</td></tr><tr><td class="p-1"><b>от</b> 1000 руб.</td><td class="p-1 font-semibold text-green-500">бесплатно</td></tr></table>',
          balloonContentFooter: ''
        }
      }, {
        fillColor: '#f19100',
        strokeColor: '#222',
        opacity: 0.6,
        strokeWidth: 0,
        strokeStyle: 'solid'
      });

      mapZones.geoObjects.add(poligons[1500]);

      poligons[10000] = new ymaps.GeoObject({
        geometry: {
          type: "Polygon",
          coordinates: [
            coordinates[1500],
            coordinates[10000]
          ],
        },
        properties: {
          hintContent: "Кликните, чтобы узнать стоимость доставки в этой зоне",
          balloonContentHeader: 'Зона 2',
          balloonContent: '<table class="table table-fixed"><tr><th class="p-1">Сумма заказа</th><th class="p-1">Стоимость доставки</th></tr><tr><td class="p-1"><b>до</b> 1500 руб.</td><td class="p-1">300 руб.</td></tr><tr><td class="p-1"><b>от</b> 1500 руб.</td><td class="p-1 font-semibold text-green-500">бесплатно</td></tr></table>',
          balloonContentFooter: ''
        }
      }, {
        fillColor: '#f1bc00',
        strokeColor: '#222',
        opacity: 0.6,
        strokeWidth: 0,
        strokeStyle: 'solid'
      });

      mapZones.geoObjects.add(poligons[10000]);

      poligons[15000] = new ymaps.GeoObject({
        geometry: {
          type: "Polygon",
          coordinates: [
            coordinates[10000],
            coordinates[15000]
          ],
        },
        properties: {
          hintContent: "Кликните, чтобы узнать стоимость доставки в этой зоне",
          balloonContentHeader: 'Зона 3',
          balloonContent: '<table class="table table-fixed"><tr><th class="p-1">Сумма заказа</th><th class="p-1">Стоимость доставки</th></tr><tr><td class="p-1"><b>до</b> 2000 руб.</td><td class="p-1">500 руб.</td></tr><tr><td class="p-1"><b>от</b> 2000 руб.</td><td class="p-1 font-semibold text-green-500">бесплатно</td></tr></table>',
          balloonContentFooter: ''
        }
      }, {
        fillColor: '#b3d949',
        strokeColor: '#222',
        opacity: 0.6,
        strokeWidth: 0,
        strokeStyle: 'solid'
      });

      mapZones.geoObjects.add(poligons[15000]);

      poligons[30000] = new ymaps.GeoObject({
        geometry: {
          type: "Polygon",
          coordinates: [
            coordinates[15000],
            coordinates[30000]
          ],
        },
        properties: {
          hintContent: "Кликните, чтобы узнать стоимость доставки в этой зоне",
          balloonContentHeader: 'Зона 4',
          balloonContent: '<table class="table table-fixed"><tr><th class="p-1">Сумма заказа</th><th class="p-1">Стоимость доставки</th></tr><tr><td class="p-1"><b>до</b> 3500 руб.</td><td class="p-1">700 руб.</td></tr><tr><td class="p-1"><b>от</b> 3500 руб.</td><td class="p-1 font-semibold text-green-500">бесплатно</td></tr></table>',
          balloonContentFooter: ''
        }
      }, {
        fillColor: '#a5b4fc',
        strokeColor: '#222',
        opacity: 0.6,
        strokeWidth: 0,
        strokeStyle: 'solid'
      });

      mapZones.geoObjects.add(poligons[30000]);
    }
  </script>
</div>
