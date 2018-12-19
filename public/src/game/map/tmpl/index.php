<?php 

$page_title = "Mapa";

$left_list_html = render_left_menu('map');

$content_html = render_content();

require_once '../masterPage.php';


function render_content(){
    ob_start();
    ?>
Mapa no functional. Solo las provincias gallegas pueden pincharse pero no tienen información en la base de datos. <br>
Las únicas provincias de las que se puede obtener información son las asturianas y cántabras. Ej:
<a href="region.php?id=103">Provincia de Avilés</a> o <a href="region.php?id=202">Merindad de Campoo</a>. 
Tienes una lista completa en la página del <a href="kingdom.php?id=1">Reino de Asturias</a>
    <img src="../../../img/Mapa españa/Mapa_v1/mapa_final_v1.gif" alt="Mapa de la península ibérica" usemap="#spain_map">

    <map name="spain_map">
      <area shape="poly" coords="4.00,456.00 224.00,456.00 224.00,456.00
             222.43,447.24 223.51,445.77 222.86,441.00
             222.37,437.38 220.94,436.12 220.30,433.00
             220.30,433.00 220.30,417.00 220.30,417.00
             220.00,414.93 219.88,412.01 220.30,410.09
             221.54,407.54 223.59,406.39 223.95,403.91
             223.95,403.91 222.95,395.00 222.95,395.00
             222.95,395.00 222.95,369.00 222.95,369.00
             222.95,369.00 221.11,360.00 221.11,360.00
             220.34,350.25 225.71,352.21 227.98,348.69
             229.13,346.90 228.97,344.07 229.00,342.00
             229.00,342.00 232.42,340.98 232.42,340.98
             232.42,340.98 242.17,329.37 242.17,329.37
             242.17,329.37 251.00,322.00 251.00,322.00
             251.00,322.00 239.00,326.39 239.00,326.39
             239.00,326.39 229.00,327.00 229.00,327.00
             228.84,319.58 225.77,315.32 232.00,310.00
             232.00,310.00 231.00,305.00 231.00,305.00
             231.00,305.00 241.90,304.23 241.90,304.23
             241.90,304.23 253.00,292.00 253.00,292.00
             248.10,294.31 246.56,297.04 243.00,297.56
             243.00,297.56 233.05,298.20 233.05,298.20
             227.55,296.90 224.33,288.36 225.83,283.13
             226.59,280.47 230.15,278.06 232.07,272.00
             233.94,266.10 231.07,262.73 233.04,259.14
             234.38,256.69 237.02,256.05 238.40,254.46
             240.22,252.37 239.97,249.59 240.00,247.00
             240.00,247.00 234.00,244.00 234.00,244.00
             227.35,249.77 226.59,247.77 224.71,249.77
             222.85,251.75 223.56,254.52 222.10,256.86
             220.30,259.73 217.42,259.92 215.58,261.72
             215.58,261.72 212.42,266.80 212.42,266.80
             210.81,268.81 206.15,272.45 203.43,270.96
             201.05,269.66 200.77,263.67 200.00,261.00
             197.48,261.21 194.66,261.43 194.56,257.94
             194.47,254.61 198.68,248.14 200.04,245.00
             203.49,237.01 203.25,223.48 216.00,222.00
             216.00,222.00 216.00,219.00 216.00,219.00
             208.38,219.00 200.63,218.41 199.00,228.00
             192.56,225.39 191.04,223.94 187.57,218.01
             184.36,212.54 184.63,211.17 191.00,209.00
             189.29,203.74 186.33,203.01 185.34,199.28
             184.64,196.65 186.58,194.22 183.67,192.17
             177.74,188.00 161.61,193.56 163.58,184.98
             163.58,184.98 166.60,177.00 166.60,177.00
             167.30,173.23 165.24,167.65 164.00,164.00
             168.91,160.34 168.07,156.20 170.59,153.56
             172.85,151.19 177.88,150.32 181.00,150.00
             179.71,148.73 178.25,147.53 177.58,145.79
             175.00,139.10 183.19,132.14 189.00,130.70
             192.25,129.89 198.55,131.38 202.00,132.00
             203.35,129.37 206.14,123.66 209.21,122.98
             209.21,122.98 216.00,122.98 216.00,122.98
             216.00,122.98 216.00,121.00 216.00,121.00
             205.58,115.09 216.72,112.55 220.74,110.46
             225.93,107.75 222.61,105.13 233.00,105.00
             233.00,105.00 233.00,100.00 233.00,100.00
             233.00,100.00 239.00,100.00 239.00,100.00
             243.24,110.34 253.14,111.45 263.00,108.57
             263.00,108.57 271.00,105.38 271.00,105.38
             276.24,104.25 278.29,107.29 281.96,105.38
             284.79,103.72 285.84,100.51 289.21,98.37
             295.30,94.50 305.99,86.58 307.00,99.00
             309.70,95.36 308.72,92.90 311.31,90.43
             317.18,84.87 325.46,94.08 328.00,99.00
             328.00,99.00 330.00,89.00 330.00,89.00
             330.00,89.00 315.00,85.00 315.00,85.00
             321.28,81.45 328.73,78.18 336.00,78.00
             336.00,78.00 336.00,75.10 336.00,75.10
             333.55,74.98 329.14,74.62 327.00,75.10
             324.22,75.96 320.72,78.50 315.01,79.36
             305.73,80.75 313.90,69.23 314.08,62.00
             314.13,60.01 313.46,58.21 315.37,56.70
             318.01,54.61 320.74,57.46 324.96,55.50
             331.29,52.57 331.48,45.96 340.00,45.00
             340.00,45.00 349.61,36.00 349.61,36.00
             349.61,36.00 357.10,26.11 357.10,26.11
             357.10,26.11 365.96,26.11 365.96,26.11
             365.96,26.11 367.79,25.30 367.79,25.30
             367.79,25.30 377.01,17.52 377.01,17.52
             377.01,17.52 379.00,14.00 379.00,14.00
             389.97,15.60 389.00,17.58 387.00,27.00
             387.00,27.00 404.83,18.57 404.83,18.57
             407.85,16.86 410.01,13.62 413.91,14.64
             413.91,14.64 423.27,19.59 423.27,19.59
             425.30,21.65 425.22,25.92 428.91,26.18
             431.61,26.37 432.06,23.34 434.30,22.38
             436.33,21.50 444.98,23.16 446.69,24.60
             448.32,25.97 448.43,27.14 449.00,29.00
             452.83,29.72 460.86,32.63 463.63,35.30
             463.63,35.30 473.72,49.51 473.72,49.51
             475.31,51.12 477.11,51.82 479.00,52.97
             485.27,56.76 488.39,57.97 496.00,57.49
             496.00,57.49 519.00,56.89 519.00,56.89
             523.72,56.38 524.56,54.51 527.42,54.33
             527.42,54.33 542.00,55.26 542.00,55.26
             542.00,55.26 548.00,56.54 548.00,56.54
             548.00,56.54 555.00,55.46 555.00,55.46
             557.83,55.53 559.91,57.17 564.00,56.86
             564.00,56.86 572.00,55.11 572.00,55.11
             580.42,55.07 593.96,64.43 600.00,55.11
             604.74,57.00 616.05,58.44 621.00,57.02
             621.00,57.02 633.00,51.64 633.00,51.64
             635.88,50.96 646.97,55.76 651.00,56.53
             658.33,57.94 663.77,52.66 667.00,52.31
             669.58,51.81 672.57,53.61 675.71,52.31
             678.29,51.47 680.90,48.00 683.17,46.22
             683.17,46.22 689.29,42.44 689.29,42.44
             690.79,41.15 692.40,38.47 694.93,38.04
             697.33,37.62 699.37,39.82 701.08,41.18
             703.07,42.75 705.37,44.19 706.86,46.26
             708.51,48.54 708.92,51.24 711.30,53.11
             715.99,56.80 719.62,52.54 722.00,60.00
             722.00,60.00 747.00,59.15 747.00,59.15
             747.00,59.15 760.96,59.15 760.96,59.15
             760.96,59.15 767.17,61.73 767.17,61.73
             767.17,61.73 779.98,63.17 779.98,63.17
             779.98,63.17 791.00,75.19 791.00,75.19
             798.27,74.26 805.79,73.96 813.00,75.19
             813.00,75.19 821.00,77.42 821.00,77.42
             824.92,77.91 828.98,76.31 834.00,77.42
             834.00,77.42 842.00,80.38 842.00,80.38
             842.00,80.38 856.00,83.60 856.00,83.60
             856.00,83.60 878.00,89.63 878.00,89.63
             878.00,89.63 904.00,91.55 904.00,91.55
             904.00,91.55 912.00,90.20 912.00,90.20
             912.00,90.20 918.00,90.99 918.00,90.99
             920.98,90.96 922.64,89.32 924.49,89.36
             926.61,89.41 927.41,91.42 931.04,91.84
             931.04,91.84 946.00,90.28 946.00,90.28
             957.11,88.22 959.36,84.73 964.00,83.21
             970.35,81.15 977.15,81.48 979.00,80.95
             982.24,80.00 984.11,77.58 987.00,76.17
             989.50,74.95 994.06,74.62 997.00,74.07
             1005.07,72.55 1009.36,69.31 1014.00,79.00
             1009.95,80.61 1009.04,81.09 1007.00,85.00
             1017.16,84.64 1012.35,79.91 1019.09,76.01
             1019.09,76.01 1026.00,73.57 1026.00,73.57
             1031.80,70.87 1038.23,66.45 1045.00,68.56
             1049.40,69.92 1051.81,73.07 1055.28,75.31
             1060.53,78.69 1067.93,76.48 1065.00,86.00
             1065.00,86.00 1079.00,87.80 1079.00,87.80
             1079.00,87.80 1092.00,90.65 1092.00,90.65
             1092.00,90.65 1104.00,98.87 1104.00,98.87
             1104.00,98.87 1114.00,98.87 1114.00,98.87
             1114.00,98.87 1123.00,102.00 1123.00,102.00
             1122.49,95.95 1125.08,96.78 1129.57,92.70
             1129.57,92.70 1137.30,84.21 1137.30,84.21
             1143.16,80.97 1151.75,85.33 1155.91,84.85
             1159.93,84.39 1161.98,80.66 1165.98,80.79
             1169.99,80.93 1170.56,84.76 1172.54,85.93
             1174.64,87.15 1177.03,85.81 1179.00,85.00
             1180.88,87.54 1188.89,91.92 1192.04,92.87
             1195.42,93.88 1195.74,93.04 1200.00,94.81
             1210.16,99.02 1207.33,99.13 1214.17,103.81
             1216.40,105.34 1231.47,112.23 1234.00,112.58
             1238.65,113.23 1244.71,109.85 1248.00,109.60
             1252.86,109.22 1254.38,113.51 1261.00,112.78
             1261.00,112.78 1285.00,105.35 1285.00,105.35
             1289.92,103.85 1291.01,105.45 1295.00,103.76
             1300.49,101.43 1301.62,97.55 1308.00,94.93
             1308.00,94.93 1330.00,87.99 1330.00,87.99
             1333.71,86.05 1339.35,79.53 1341.78,76.00
             1347.76,67.32 1352.17,55.68 1356.33,46.00
             1356.33,46.00 1363.19,30.00 1363.19,30.00
             1363.19,30.00 1363.19,22.00 1363.19,22.00
             1363.26,18.36 1366.76,5.94 1364.40,4.02
             1362.85,2.77 1358.95,3.00 1357.00,3.00
             1357.00,3.00 685.00,3.00 685.00,3.00
             685.00,3.00 13.00,3.00 13.00,3.00
             11.01,3.00 7.19,2.77 5.60,4.02
             3.90,5.37 4.04,8.05 4.00,10.00
             4.00,10.00 4.00,28.00 4.00,28.00
             4.00,28.00 4.00,109.00 4.00,109.00
             4.00,109.00 4.00,456.00 4.00,456.00" href="region.php?id=0" alt="Mar">
      <area shape="poly" coords="411.24,61.55 413.27,63.68 417.01,63.94
             423.00,64.35 425.16,61.57 428.00,61.56
             429.53,61.55 430.71,62.15 431.94,62.99
             436.77,66.30 436.21,70.01 435.00,75.00
             435.00,75.00 441.09,77.97 441.09,77.97
             441.09,77.97 448.69,77.97 448.69,77.97
             448.69,77.97 455.00,91.00 455.00,91.00
             458.72,90.58 467.70,93.03 470.50,95.58
             472.24,97.16 473.56,100.77 474.29,103.00
             475.56,106.86 475.70,112.51 478.55,115.43
             483.31,120.32 494.78,116.75 496.13,111.94
             497.05,108.69 494.21,107.00 494.00,99.00
             486.90,96.89 484.69,89.90 489.77,84.43
             492.84,81.12 495.68,83.40 498.91,81.89
             505.88,78.63 507.30,70.55 509.00,64.00
             496.91,62.18 500.15,63.76 493.00,63.20
             493.00,63.20 486.00,62.03 486.00,62.03
             482.46,62.01 479.68,63.30 477.22,62.03
             474.86,60.63 473.97,57.24 472.46,55.00
             472.46,55.00 460.82,40.25 460.82,40.25
             457.77,36.74 452.12,35.68 448.00,33.62
             444.25,31.74 440.71,28.03 436.10,29.68
             431.04,31.50 431.66,38.38 428.57,39.83
             422.65,42.62 420.61,28.43 420.00,25.00
             410.27,27.14 415.31,34.19 414.55,39.96
             414.14,43.16 411.69,44.18 410.59,47.09
             410.59,47.09 408.00,60.00 408.00,60.00" href="region.php?id=16" alt="A Mariña">
      <area shape="poly" coords="412.96,70.70 405.48,72.47 404.57,73.42
             403.26,74.76 402.34,78.14 401.40,80.00
             398.03,86.71 393.23,94.14 385.00,94.00
             382.54,102.67 386.40,106.89 376.00,112.00
             376.00,112.00 378.31,119.00 378.31,119.00
             378.31,119.00 373.91,132.00 373.91,132.00
             373.91,132.00 375.00,148.00 375.00,148.00
             379.66,145.95 383.58,142.45 389.00,143.21
             398.16,144.51 398.54,149.97 404.96,148.07
             404.96,148.07 412.09,144.55 412.09,144.55
             414.84,143.61 416.60,144.27 419.83,142.11
             423.37,139.75 425.86,135.36 430.94,136.85
             433.21,137.52 433.90,138.95 435.59,140.30
             435.59,140.30 440.41,143.56 440.41,143.56
             442.19,145.53 441.75,147.78 443.02,149.42
             443.98,150.66 451.39,154.36 453.00,154.67
             459.59,155.94 458.56,149.65 464.02,147.78
             467.44,146.61 470.18,148.88 472.41,147.19
             473.43,146.42 476.49,135.97 482.78,139.72
             483.97,140.43 484.28,141.19 485.00,142.00
             492.03,139.54 489.30,129.19 487.00,124.00
             484.95,124.37 482.07,125.06 480.04,124.65
             475.91,123.82 469.81,115.71 468.65,111.91
             468.65,111.91 468.00,101.00 468.00,101.00
             465.02,100.10 462.12,98.62 459.00,98.31
             456.15,98.02 453.61,98.94 451.39,97.31
             448.67,95.32 446.71,87.34 446.00,84.00
             440.98,84.00 429.55,82.88 427.88,76.87
             427.27,74.68 429.36,70.50 430.00,68.00
             428.48,68.56 427.89,68.55 426.54,69.70
             424.87,71.13 421.95,77.27 417.26,74.34
             415.43,73.19 415.25,71.89 415.00,70.00
" href="region.php?id=17" alt="Terra Chá">
      <area shape="poly" coords="420.48,151.40 417.51,155.97 414.00,150.00
             409.31,152.79 406.94,156.99 401.01,155.10
             397.54,154.00 396.80,152.97 395.00,150.00
             395.00,150.00 384.00,150.00 384.00,150.00
             381.68,153.02 377.41,156.45 376.68,160.00
             375.59,165.32 380.37,174.47 380.75,179.00
             381.20,184.40 378.35,186.42 375.85,190.42
             372.63,195.57 374.71,195.16 368.91,200.00
             368.91,200.00 368.91,202.00 368.91,202.00
             374.79,207.84 367.60,208.23 368.91,214.01
             369.16,216.13 370.78,218.02 372.21,219.56
             377.27,225.00 382.70,226.97 390.00,226.00
             391.24,217.10 396.51,213.99 405.00,214.59
             409.48,214.91 411.36,215.19 414.86,218.47
             418.60,221.98 420.22,230.16 427.02,233.49
             432.00,236.02 434.38,232.99 437.96,233.49
             441.93,233.93 448.70,239.90 451.00,243.00
             456.90,241.04 459.38,239.62 461.00,247.00
             461.00,247.00 475.00,249.00 475.00,249.00
             476.28,245.79 477.57,241.78 479.50,239.00
             482.43,234.79 486.85,230.77 486.41,225.00
             485.81,217.25 478.63,217.53 479.00,208.00
             472.50,205.73 469.21,208.80 465.31,206.02
             462.30,203.85 463.32,200.12 462.86,197.00
             462.28,193.11 460.17,191.35 460.60,189.21
             461.41,185.23 471.44,181.77 475.00,181.00
             475.00,181.00 470.71,167.00 470.71,167.00
             470.71,167.00 467.00,153.00 467.00,153.00
             467.00,153.00 465.00,153.00 465.00,153.00
             462.59,159.52 462.78,159.36 456.00,160.12
             456.00,160.12 451.00,160.70 451.00,160.70
             447.57,160.34 440.78,154.53 438.28,152.05
             436.51,150.28 432.02,145.31 429.80,144.70
             428.05,144.21 424.19,146.39 422.00,147.00
" href="region.php?id=18" alt="Comarca de Lugo">
      <area shape="poly" coords="497.54,123.67 494.95,122.82 494.42,126.13
             494.19,127.75 498.36,141.36 494.42,145.41
             493.11,146.72 490.74,147.13 489.00,147.57
             487.70,147.90 486.36,148.34 485.00,148.37
             482.96,148.40 480.93,147.58 479.00,147.00
             476.01,154.62 474.76,159.65 476.68,168.00
             477.94,173.51 481.48,177.94 480.64,181.94
             479.53,187.27 472.38,186.41 469.61,189.56
             467.53,191.92 469.32,194.66 468.00,201.00
             473.48,201.65 475.71,199.56 480.94,203.11
             486.16,206.64 484.10,209.47 487.00,213.79
             488.67,216.27 490.85,216.98 491.69,220.10
             492.38,222.67 491.54,227.31 492.57,229.63
             493.46,231.61 495.96,233.10 497.58,235.10
             501.04,239.39 498.19,237.61 505.00,245.00
             505.00,245.00 509.00,244.00 509.00,244.00
             508.22,241.22 506.45,237.76 507.11,235.00
             508.41,229.50 512.76,227.30 516.83,224.34
             518.49,223.14 519.96,221.35 522.09,221.06
             523.50,220.86 525.62,221.62 527.00,222.00
             530.11,217.82 533.95,213.33 534.90,208.00
             535.91,202.34 531.03,199.70 537.00,196.00
             537.00,196.00 537.85,182.14 537.85,182.14
             536.42,179.00 529.15,177.78 524.41,172.76
             522.80,171.04 518.87,165.28 518.84,162.99
             518.76,155.52 527.80,153.57 532.83,151.18
             536.38,149.50 536.68,148.46 541.00,147.00
             538.42,135.79 530.26,148.40 525.01,148.37
             521.55,148.35 517.70,143.23 517.57,140.00
             517.49,138.21 518.34,136.60 519.00,135.00
             511.00,130.37 503.93,125.95 503.00,116.00
             503.00,116.00 501.00,116.00 501.00,116.00
" href="region.php?id=19" alt="Os Ancares">
      <area shape="poly" coords="401.00,220.00 396.17,225.37 396.17,225.37
             394.90,227.40 395.04,229.75 393.41,231.18
             390.85,233.41 387.28,230.92 383.65,237.04
             381.36,240.91 381.95,248.25 376.00,260.00
             381.76,262.66 382.45,263.70 381.00,270.00
             392.86,273.13 394.21,277.17 399.17,279.86
             404.45,282.72 406.60,280.33 410.00,287.00
             415.49,288.34 417.76,290.42 422.00,293.79
             430.18,290.10 429.28,295.32 437.00,293.79
             444.48,291.91 451.76,286.20 453.09,285.85
             453.09,285.85 468.00,287.47 468.00,287.47
             475.46,289.38 475.06,294.15 487.00,296.00
             487.81,284.24 493.82,284.89 498.61,276.99
             502.03,271.34 501.26,267.97 502.75,263.00
             503.69,259.86 505.52,256.58 504.69,253.17
             503.71,249.11 498.98,247.08 496.11,244.55
             492.98,241.79 492.47,239.69 491.00,236.00
             491.00,236.00 483.34,243.14 483.34,243.14
             481.26,246.42 479.52,253.30 475.87,255.01
             472.85,256.44 470.08,253.80 467.00,252.98
             471.14,254.08 451.76,250.09 456.00,250.72
             450.69,249.93 446.01,252.75 445.00,244.00
             442.57,242.51 438.82,239.72 436.00,239.69
             432.65,239.65 431.00,242.24 427.28,240.40
             424.08,238.81 415.94,231.69 413.70,228.75
             410.98,225.18 411.67,221.74 401.00,220.00" href="region.php?id=20" alt="Terra de Lemos">
      <area shape="poly" coords="522.00,274.00 519.69,277.85 519.69,277.85
             519.69,277.85 505.00,276.00 505.00,276.00
             500.60,285.65 496.35,286.00 493.45,291.17
             493.45,291.17 488.00,304.00 488.00,304.00
             487.24,305.87 486.82,309.17 485.41,310.47
             482.38,313.27 475.27,309.22 477.00,300.00
             474.14,297.88 470.88,294.24 467.96,293.01
             465.57,292.00 463.50,292.09 461.00,291.90
             459.32,291.88 456.54,291.54 455.00,291.90
             455.00,291.90 437.00,299.36 437.00,299.36
             432.31,300.66 419.56,295.25 423.16,305.87
             424.20,308.93 426.48,309.46 427.99,312.13
             427.99,312.13 429.92,317.72 429.92,317.72
             431.17,320.31 438.88,330.70 441.13,331.83
             444.30,333.42 454.24,334.19 456.23,336.35
             459.54,339.95 457.55,344.36 459.44,347.70
             461.68,351.65 467.52,350.29 471.12,355.14
             476.07,361.82 474.27,365.30 475.62,368.83
             476.28,370.56 479.61,374.12 481.00,376.00
             485.40,375.21 491.61,374.39 496.00,375.39
             500.66,376.46 502.96,379.62 506.00,380.23
             511.91,381.42 514.73,374.45 516.00,370.00
             512.76,368.65 506.81,366.84 505.96,362.95
             505.22,359.57 510.79,354.84 512.95,352.01
             512.95,352.01 518.00,346.57 518.00,346.57
             519.86,344.08 519.78,341.56 521.58,339.11
             522.59,337.73 533.52,329.14 535.00,328.60
             536.83,327.92 539.07,328.02 541.00,328.00
             544.49,321.01 548.63,322.47 551.01,313.00
             551.37,311.58 551.85,309.54 551.59,308.09
             550.47,301.88 540.62,302.20 536.94,295.18
             535.47,292.38 537.46,291.54 538.46,288.82
             538.46,288.82 540.00,280.00 540.00,280.00
             540.00,280.00 522.00,274.00 522.00,274.00
" href="region.php?id=21" alt="Valdeorras">
      <area shape="poly" coords="407.28,323.73 404.47,325.25 399.23,328.00
             403.76,339.59 402.22,333.72 399.23,345.00
             398.85,347.47 398.97,350.67 396.69,352.34
             392.40,355.49 389.40,348.31 385.11,348.99
             381.78,349.52 380.01,355.67 375.00,356.04
             372.18,356.24 370.49,354.08 368.00,353.36
             365.13,352.53 354.85,354.15 352.13,355.51
             343.44,359.86 351.78,366.85 349.02,374.00
             346.35,380.88 330.07,387.72 331.81,395.91
             332.32,398.36 334.90,399.88 336.55,403.04
             338.30,406.40 337.77,410.16 341.15,411.35
             344.74,412.62 349.47,409.07 352.00,406.88
             352.00,406.88 363.70,397.32 363.70,397.32
             366.43,394.67 366.84,391.33 371.02,390.32
             378.72,388.46 379.14,395.95 383.21,396.58
             386.22,397.05 398.39,391.30 405.00,392.34
             405.00,392.34 425.00,400.00 425.00,400.00
             425.00,400.00 424.00,404.00 424.00,404.00
             429.27,403.02 433.68,400.10 437.00,400.18
             442.33,400.32 445.72,404.52 449.00,404.78
             449.00,404.78 461.00,402.79 461.00,402.79
             466.47,402.00 475.33,398.54 477.40,393.00
             478.04,391.29 478.00,388.83 478.00,387.00
             478.00,385.14 478.04,382.75 477.40,381.00
             476.05,377.32 472.30,374.86 470.49,371.00
             468.61,366.99 469.81,362.46 466.04,358.50
             463.52,355.86 460.98,357.25 458.13,355.33
             454.34,352.77 452.67,346.28 452.00,342.00
             448.58,341.39 440.89,339.68 438.37,337.49
             435.94,335.38 433.72,330.68 431.54,328.05
             427.20,322.81 424.62,324.65 424.00,317.00
             415.59,318.97 419.12,320.28 410.00,318.00" href="region.php?id=22" alt="Limia">
      <area shape="poly" coords="311.78,284.03 313.90,290.02 314.71,296.00
             315.13,299.07 314.89,302.08 316.45,304.90
             318.68,308.91 322.34,309.17 323.53,312.21
             324.42,314.85 322.27,318.07 323.53,322.00
             324.63,325.06 330.13,332.20 329.48,337.99
             329.11,341.25 326.30,342.49 324.00,347.00
             327.49,347.28 329.12,347.45 331.70,350.14
             334.49,353.05 336.60,358.29 341.83,357.14
             344.11,356.64 346.28,353.67 348.04,352.14
             348.04,352.14 360.05,345.16 360.05,345.16
             362.79,344.36 370.53,349.36 373.91,349.57
             377.70,349.81 379.37,345.78 383.00,344.03
             386.93,342.13 390.46,344.38 394.00,346.00
             394.40,340.20 396.07,338.39 396.15,336.00
             396.29,332.35 393.11,329.89 395.04,326.10
             396.61,323.02 400.23,322.17 402.22,319.61
             404.00,317.32 406.92,305.32 415.00,314.00
             418.21,311.59 417.87,310.89 418.00,307.00
             418.00,307.00 415.00,307.00 415.00,307.00
             415.31,303.17 416.95,297.61 414.26,294.43
             410.79,290.32 407.32,294.25 405.00,287.00
             396.38,286.78 392.79,281.61 385.00,278.38
             382.16,277.20 376.53,275.64 374.65,273.57
             372.18,270.84 372.74,269.00 374.00,266.00
             366.50,258.60 362.83,267.03 357.99,267.31
             362.84,267.03 338.18,265.58 341.00,265.87
             338.97,265.66 336.09,264.58 334.26,265.27
             332.56,265.92 331.61,267.87 329.74,268.99
             327.61,270.27 325.99,269.72 323.71,271.56
             319.20,275.19 320.20,278.15 313.00,278.00" href="region.php?id=23" alt="Comarca de Ourense">
      <area shape="poly" coords="331.95,211.56 328.84,210.71 323.00,210.00
             320.56,213.67 320.06,213.42 316.00,212.00
             312.44,220.52 309.37,218.05 304.17,220.99
             301.44,222.53 299.85,225.36 296.00,226.26
             292.69,227.45 288.52,226.15 285.00,226.26
             285.00,226.26 273.00,227.00 273.00,227.00
             273.00,227.00 273.00,248.00 273.00,248.00
             277.05,248.91 288.82,255.05 291.28,258.21
             294.82,262.76 296.07,270.77 302.04,273.13
             304.83,274.23 313.10,272.61 315.63,271.03
             315.63,271.03 321.10,266.20 321.10,266.20
             321.10,266.20 333.99,258.72 333.99,258.72
             338.06,256.88 338.61,260.49 343.04,260.67
             343.04,260.67 355.91,260.67 355.91,260.67
             358.81,260.04 359.77,258.12 363.04,257.31
             365.70,256.65 368.92,257.46 371.50,255.26
             373.97,253.16 375.82,245.30 376.55,242.00
             376.92,240.32 378.26,232.52 377.72,231.31
             376.70,229.00 373.80,229.34 371.32,227.41
             368.67,225.33 362.51,216.37 362.48,213.00
             362.47,211.35 363.49,208.65 364.00,207.00
             364.00,207.00 356.00,208.70 356.00,208.70
             356.00,208.70 349.00,206.93 349.00,206.93
             349.00,206.93 334.00,205.00 334.00,205.00" href="region.php?id=24" alt="Deza">
      <area shape="poly" coords="257.12,285.00 257.12,293.96 257.12,293.96
             256.37,296.97 253.57,298.16 251.63,300.37
             246.81,305.90 248.35,310.24 239.00,311.00
             239.00,311.00 239.00,320.00 239.00,320.00
             239.00,320.00 255.74,313.98 255.74,313.98
             255.74,313.98 264.00,308.66 264.00,308.66
             264.00,308.66 288.00,308.66 288.00,308.66
             288.00,308.66 295.00,309.90 295.00,309.90
             295.00,309.90 309.00,308.00 309.00,308.00
             309.00,308.00 309.75,298.00 309.75,298.00
             309.75,298.00 306.00,281.94 306.00,281.94
             304.25,282.29 303.00,282.77 301.26,281.94
             298.78,280.64 288.84,265.57 286.05,262.14
             282.30,257.54 274.65,258.48 270.02,255.98
             262.11,251.72 265.46,240.11 269.00,234.00
             265.06,232.45 257.99,231.50 254.98,235.43
             254.98,235.43 252.17,242.00 252.17,242.00
             252.17,242.00 247.79,250.00 247.79,250.00
             247.79,250.00 246.71,254.74 246.71,254.74
             245.22,257.77 240.70,258.93 239.70,262.29
             239.24,263.84 240.36,267.78 240.45,270.00
             240.55,272.75 239.49,279.36 238.70,281.98
             237.15,287.21 233.50,286.27 232.17,288.52
             230.18,291.90 236.54,291.46 238.00,291.57
             248.65,292.38 247.31,286.53 257.12,285.00
" href="region.php?id=25" alt="Comarca de Pontevedra">
      <area shape="poly" coords="311.72,318.40 307.99,317.73 302.00,318.08
             302.00,318.08 292.00,318.08 292.00,318.08
             292.00,318.08 286.00,317.55 286.00,317.55
             286.00,317.55 271.00,317.55 271.00,317.55
             262.47,317.40 260.62,322.92 254.70,327.80
             254.70,327.80 245.42,333.85 245.42,333.85
             243.20,335.47 240.00,338.57 239.02,341.17
             236.89,346.87 241.09,356.18 229.00,354.00
             226.43,363.79 228.32,366.73 228.28,375.72
             228.24,382.04 227.22,387.75 229.00,394.00
             236.18,390.59 236.15,387.12 241.10,382.05
             245.33,377.74 247.59,377.97 250.37,374.78
             252.63,372.19 254.17,367.77 259.00,364.74
             262.20,362.73 266.24,362.95 270.00,361.78
             270.00,361.78 283.00,356.39 283.00,356.39
             283.00,356.39 296.00,355.79 296.00,355.79
             301.03,355.09 307.31,352.02 312.00,350.00
             312.95,345.84 314.78,343.21 319.00,342.00
             321.03,338.28 324.23,334.76 322.41,330.21
             321.06,326.86 317.78,326.71 317.27,321.00
             316.96,317.45 318.09,317.35 316.00,314.00" href="region.php?id=26" alt="Comarca de Vigo">
      <area shape="poly" coords="372.00,67.98 371.61,74.24 369.41,76.40
             366.93,78.82 356.65,78.00 353.00,78.00
             353.31,83.61 354.83,85.76 354.83,88.00
             354.83,88.00 353.44,97.00 353.44,97.00
             353.02,104.99 355.29,105.63 348.00,109.00
             350.16,114.72 348.90,114.83 350.00,118.00
             352.34,124.70 355.77,124.01 352.00,133.00
             355.53,134.78 358.70,137.83 354.59,141.40
             352.11,143.55 348.86,142.56 346.13,143.74
             342.87,145.14 342.06,148.41 339.23,149.41
             337.60,149.99 332.15,148.66 330.00,148.51
             323.29,148.05 321.19,151.17 317.00,144.00
             311.01,147.24 309.48,147.24 306.00,141.00
             296.55,141.28 301.41,136.47 300.00,129.00
             300.00,129.00 292.91,133.00 292.91,133.00
             292.91,133.00 287.37,135.00 287.37,135.00
             287.37,135.00 282.79,138.87 282.79,138.87
             282.79,138.87 276.17,142.43 276.17,142.43
             276.17,142.43 266.13,152.86 266.13,152.86
             266.13,152.86 261.00,151.00 261.00,151.00
             261.00,156.50 262.35,160.98 256.88,164.00
             256.86,165.78 256.33,169.36 256.88,170.91
             257.66,174.10 262.46,178.97 266.01,177.85
             271.06,176.26 272.24,170.68 278.00,177.00
             278.00,177.00 280.00,177.00 280.00,177.00
             286.61,169.17 288.32,175.20 296.00,175.62
             299.04,175.79 303.19,174.34 304.77,178.15
             306.07,181.29 302.72,184.53 302.23,189.00
             301.73,193.51 304.03,195.23 304.58,198.00
             304.58,198.00 304.00,207.00 304.00,207.00
             306.64,205.59 309.81,202.48 312.01,202.13
             315.48,201.58 316.76,204.52 322.00,203.71
             328.23,202.75 331.59,199.72 334.00,199.18
             336.71,198.57 338.44,199.92 341.00,200.28
             347.73,201.24 348.45,197.67 356.00,203.00
             364.36,197.65 366.70,195.30 371.64,187.00
             372.84,184.97 374.19,183.40 374.67,181.00
             375.41,177.29 371.90,169.45 371.02,165.00
             369.62,157.92 372.34,158.12 372.07,154.00
             371.98,152.61 368.25,141.90 368.05,137.00
             367.72,129.17 371.79,123.85 371.96,120.00
             372.10,116.87 370.00,115.06 371.15,112.00
             372.23,109.14 376.42,106.19 377.97,103.00
             379.98,98.87 377.43,95.73 377.97,93.13
             378.95,88.36 387.21,88.09 391.00,87.00
             393.11,77.39 403.70,72.97 398.00,62.00
             398.00,62.00 379.00,62.00 379.00,62.00
             379.00,62.00 372.00,65.00 372.00,65.00
" href="region.php?id=27" alt="Comarca de Santiago">
      <area shape="poly" coords="188.37,142.15 190.04,148.61 185.85,152.85
             180.87,157.91 175.27,154.47 171.50,164.00
             169.72,168.48 172.74,169.92 173.18,174.00
             173.58,177.65 171.12,181.49 170.00,185.00
             174.27,182.79 179.10,177.79 183.95,181.67
             185.94,183.26 186.78,185.29 187.88,186.45
             189.61,188.27 192.02,188.69 192.68,190.43
             193.63,192.88 190.62,195.40 191.65,198.83
             192.43,201.44 195.69,203.18 195.71,207.00
             195.74,212.46 191.39,211.39 194.00,219.00
             194.00,219.00 196.00,219.00 196.00,219.00
             196.00,219.00 197.00,213.00 197.00,213.00
             197.00,213.00 206.00,211.33 206.00,211.33
             209.55,211.24 211.39,213.31 215.00,211.98
             218.86,210.55 221.11,206.41 225.02,205.81
             229.82,205.07 233.16,208.68 228.00,212.00
             228.19,213.92 228.81,216.71 227.31,218.25
             226.21,219.39 224.18,219.32 222.17,220.67
             222.17,220.67 213.63,227.85 213.63,227.85
             207.65,233.25 206.19,241.74 203.80,249.00
             203.00,251.42 201.32,254.47 202.23,256.98
             203.22,259.71 205.61,260.85 208.00,262.00
             208.00,262.00 215.63,253.56 215.63,253.56
             217.72,250.71 219.69,245.96 222.45,243.74
             224.64,241.98 226.94,242.19 228.41,240.99
             230.54,239.25 230.08,235.35 233.11,234.45
             236.98,233.30 240.02,239.19 241.00,242.00
             248.87,237.47 247.55,235.00 251.30,231.39
             255.30,227.53 261.69,225.97 267.00,227.00
             268.82,223.45 274.85,219.14 279.04,219.02
             279.04,219.02 286.00,219.88 286.00,219.88
             290.07,220.76 292.98,222.87 296.56,219.88
             303.58,213.42 298.48,211.28 297.68,205.00
             297.68,205.00 297.68,199.00 297.68,199.00
             297.36,192.17 296.22,190.31 297.68,183.00
             295.90,182.12 292.26,180.30 290.04,180.52
             286.44,180.89 285.09,184.64 281.96,184.98
             279.14,185.28 276.74,182.41 274.00,182.02
             270.93,181.58 269.17,183.92 265.00,183.84
             259.82,183.74 252.29,177.85 250.90,172.96
             250.27,171.17 250.56,168.80 250.90,167.00
             251.86,163.27 254.42,160.44 256.00,157.00
             254.00,156.07 244.84,152.83 243.00,153.02
             239.28,152.72 236.01,156.15 232.31,153.02
             229.78,151.25 229.91,146.21 229.00,143.00
             219.16,145.22 221.83,141.29 216.00,140.86
             212.15,140.58 211.42,143.67 205.00,141.78
             197.82,139.66 195.63,135.74 187.00,137.00" href="region.php?id=28" alt="Comarca de Fisterra">
      <area shape="poly" coords="323.66,73.90 322.45,71.54 326.09,70.38
             328.66,69.57 331.09,71.30 333.74,70.38
             338.07,68.83 336.08,64.94 345.00,67.00
             345.00,67.00 336.00,83.00 336.00,83.00
             337.36,83.86 339.13,84.68 339.83,86.25
             341.44,89.87 336.36,90.81 335.15,93.30
             333.78,96.10 338.07,105.78 331.93,107.26
             326.91,108.46 323.93,101.29 321.17,98.52
             319.55,96.90 317.07,95.96 315.00,95.00
             314.41,99.48 311.35,107.93 305.18,104.94
             303.20,103.98 301.58,100.94 297.00,98.00
             294.40,102.34 284.98,110.47 280.00,111.66
             276.72,112.09 274.71,110.64 268.96,111.66
             254.71,114.92 250.63,119.89 238.00,108.00
             238.00,108.00 229.28,112.31 229.28,112.31
             229.28,112.31 223.96,116.00 223.96,116.00
             223.96,116.00 220.00,117.00 220.00,117.00
             220.57,119.19 221.95,122.77 221.30,124.89
             219.85,129.62 212.65,129.55 210.21,130.72
             207.73,131.92 207.12,133.69 206.00,136.00
             206.00,136.00 210.00,137.00 210.00,137.00
             214.05,132.37 220.33,132.67 226.00,134.00
             226.00,134.00 225.00,138.00 225.00,138.00
             236.28,138.35 235.22,142.74 238.54,144.98
             238.54,144.98 250.96,148.23 250.96,148.23
             254.72,148.74 255.83,146.04 259.04,145.21
             261.37,144.61 264.58,145.59 267.00,146.00
             267.83,143.87 269.10,139.91 270.56,138.31
             272.49,136.18 275.50,135.87 278.00,134.66
             278.00,134.66 289.00,128.55 289.00,128.55
             291.58,127.23 294.91,124.23 297.00,123.65
             303.85,121.76 305.73,131.54 306.99,133.72
             306.99,133.72 312.00,140.00 312.00,140.00
             313.46,139.67 315.54,139.06 317.00,139.18
             317.67,139.23 328.29,142.53 333.00,142.53
             338.58,142.53 341.24,140.08 346.00,138.00
             344.76,131.00 342.97,130.59 348.00,126.00
             348.00,126.00 344.97,122.73 344.97,122.73
             344.97,122.73 341.01,110.00 341.01,110.00
             341.01,110.00 346.00,102.00 346.00,102.00
             342.49,98.92 341.87,97.76 346.00,95.00
             345.45,87.55 346.60,89.95 347.23,85.00
             347.68,81.46 345.50,75.84 351.06,73.60
             354.36,72.27 361.01,73.87 363.64,71.98
             367.08,69.51 363.00,65.90 365.64,62.30
             367.08,60.34 370.83,59.13 373.00,57.86
             375.48,56.42 378.35,53.75 381.00,53.07
             385.61,51.89 396.35,55.69 401.00,57.00
             401.00,57.00 403.64,46.00 403.64,46.00
             403.64,46.00 406.52,38.00 406.52,38.00
             406.52,38.00 406.52,32.00 406.52,32.00
             406.52,32.00 409.00,23.00 409.00,23.00
             394.70,25.33 398.58,33.01 387.96,39.11
             383.35,41.76 377.44,38.96 378.52,34.70
             378.52,34.70 380.65,29.00 380.65,29.00
             380.65,29.00 383.00,21.00 383.00,21.00
             377.30,23.43 371.88,28.99 367.00,30.70
             363.82,31.82 360.58,30.45 359.07,32.60
             357.14,35.38 361.59,39.54 356.77,43.26
             353.85,45.51 350.86,44.36 347.17,46.30
             347.17,46.30 342.83,49.13 342.83,49.13
             332.24,54.96 337.60,53.01 330.79,58.37
             330.79,58.37 324.47,62.07 324.47,62.07
             321.61,64.37 318.04,71.47 317.00,75.00" href="region.php?id=29" alt="Comarca de A Coruña">
      
    </map> 


    <?php
    return ob_get_clean(); 
}

    
   