
include 'config/database.php';


$points = '{"points"=[{ "index":1, "target":179189, "min":146934.98, "max":211443.02},{ "index":2, "target":166541, "min":136563.62, "max":196518.38},{ "index":3, "target":160873, "min":131915.86, "max":189830.14},{ "index":4, "target":175316, "min":143759.12, "max":206872.88},{ "index":5, "target":164609, "min":134979.38, "max":194238.62},{ "index":6, "target":164111, "min":134571.02, "max":193650.98},{ "index":7, "target":166561, "min":136580.02, "max":196541.98},{ "index":8, "target":178030, "min":145984.6, "max":210075.4},{ "index":9, "target":161648, "min":132551.36, "max":190744.64},{ "index":10, "target":140404, "min":115131.28, "max":165676.72},{ "index":11, "target":173409, "min":142195.38, "max":204622.62},{ "index":12, "target":186337, "min":152796.34, "max":219877.66},{ "index":13, "target":164321, "min":134743.22, "max":193898.78},{ "index":14, "target":196700, "min":161294, "max":232106},{ "index":15, "target":160585, "min":131679.7, "max":189490.3},{ "index":16, "target":105890, "min":86829.8, "max":124950.2},{ "index":17, "target":163661, "min":134202.02, "max":193119.98},{ "index":18, "target":157043, "min":128775.26, "max":185310.74},{ "index":19, "target":160260, "min":131413.2, "max":189106.8},{ "index":20, "target":162371, "min":133144.22, "max":191597.78},{ "index":21, "target":156987, "min":128729.34, "max":185244.66},{ "index":22, "target":155572, "min":127569.04, "max":183574.96},{ "index":23, "target":167545, "min":137386.9, "max":197703.1},{ "index":24, "target":159076, "min":130442.32, "max":187709.68},{ "index":25, "target":159458, "min":130755.56, "max":188160.44},{ "index":26, "target":154697, "min":126851.54, "max":182542.46},{ "index":27, "target":156962, "min":128708.84, "max":185215.16},{ "index":28, "target":151867, "min":124530.94, "max":179203.06},{ "index":29, "target":161326, "min":132287.32, "max":190364.68},{ "index":30, "target":154368, "min":126581.76, "max":182154.24},{ "index":31, "target":164127, "min":134584.14, "max":193669.86},{ "index":32, "target":168011, "min":137769.02, "max":198252.98},{ "index":33, "target":157868, "min":129451.76, "max":186284.24},{ "index":34, "target":171709, "min":140801.38, "max":202616.62},{ "index":35, "target":144161, "min":118212.02, "max":170109.98},{ "index":36, "target":167353, "min":137229.46, "max":197476.54},{ "index":37, "target":167400, "min":137268, "max":197532},{ "index":38, "target":171824, "min":140895.68, "max":202752.32},{ "index":39, "target":168401, "min":138088.82, "max":198713.18},{ "index":40, "target":196726, "min":161315.32, "max":232136.68},{ "index":41, "target":130008, "min":106606.56, "max":153409.44},{ "index":42, "target":165150, "min":135423, "max":194877},{ "index":43, "target":166633, "min":136639.06, "max":196626.94},{ "index":44, "target":170841, "min":140089.62, "max":201592.38},{ "index":45, "target":163056, "min":133705.92, "max":192406.08},{ "index":46, "target":167109, "min":137029.38, "max":197188.62},{ "index":47, "target":168116, "min":137855.12, "max":198376.88},{ "index":48, "target":162921, "min":133595.22, "max":192246.78},{ "index":49, "target":174126, "min":142783.32, "max":205468.68},{ "index":50, "target":142530, "min":116874.6, "max":168185.4},{ "index":51, "target":164706, "min":135058.92, "max":194353.08},{ "index":52, "target":177279, "min":145368.78, "max":209189.22}]}';

$points = $_POST['points'];

$query = "INSERT INTO alert.forecasts ,frequency,delivery,productname,productid, forecastname,functionalform,points,description,createdby,modifiedby,created,modified) VALUES (0,1,'Lantus',2,'Jim FY16','2x','" . $points . "','',1,5, NOW(),NOW());";

//insert
$stmt = $con->prepare($query);
$stmt->execute();
$query = "commit;";
$stmt = $con->prepare($query);
$stmt->execute();

echo "added";
