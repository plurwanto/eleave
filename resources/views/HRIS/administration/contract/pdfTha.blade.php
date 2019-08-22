<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <style>

        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ PUBLIC_PATH('fonts/THSarabunNew.ttf') }}") format('truetype');
        }

        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 13px;
            color: black;
            counter-increment: pageTotal;
        }
        .tha {
            font-family: "THSarabunNew";

        }


        @page {
            margin: 90px 50px 110px 50px;
        }

        #header {
            position: fixed;
            left: 0px; right: 0px; top: 0px;
            text-align: center;
            height: 90px;
        }

        #header-second {
            position: absolute;
            left: -20px; right: -20px; top: -200px;
            text-align: center;
            height: 190px;
        }

        #header-second img{
            width: 300px;
            top: 120px;
            position: absolute;
            right: 0;
        }

        #footer {
            position: fixed;
            bottom: -110px;
            left: 0px;
            height: 110px;
            right: 0px;
            border-top: 2px solid black;
        }

        #footer .right {
            float: right;
        }

        #footer .left {
            float: left;
        }

        #footer .page:after {
            counter-increment: page;
            content: "Page " counter(page) " of 4";
        }

        #footer .footer-confidential {
            font-size: 11px;
            font-style: italic;
        }

        #footer .footer-company {
            text-align: center;
        }

        #footer.footer-company div {
            margin-bottom: 5px;
        }

        #footer .footer-company div:first-child {
            font-weight: bold
        }


/* Create two equal columns that floats next to each other */
.column {
  float: left;
  width: 50%;
  padding: 10px;
  height: 300px; /* Should be removed. Only for demonstration */
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}
    </style>

</head>

<body>
    <div id="header"></div>
    <div id="header-second">
        <img src="http://elabram.com/wp-content/uploads/2016/08/Elarbam-600px.png">
    </div>
    <div id="footer">
        <div class="left">
            <span>{{$contract->cont_no_footer}} - {{$contract->name}}</span>
        </div>
        <div class="right">
            <span class="page"></span>
        </div>
        <div id="clear"></div>
        <p class="footer-confidential">This document is confidential and released by PT. Elabram Systems</p>
        <div class="footer-company">
            <div>PT. Elabram Systems</div>
            <div>Pusat Bisnis Thamrin City Lt. 7 Jl. Thamrin Boulevard (d/h Jl. Kebon Kacang Raya), Jakarta Pusat
                10340</div>
            <div>Telp : +62 21 2955 8688</div>
        </div>
    </div>
<div id="content">

<div class="row">
  <div class="column" style="background-color:#aaa;">
    <h2>Column 1</h2>
    <p>


        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur a elementum nulla. Mauris gravida, felis in cursus malesuada, libero est ultricies neque, tempus ultrices orci magna sed justo. Quisque laoreet aliquet elit vel tincidunt. Proin vitae consequat quam. Nullam ac rhoncus orci. Nullam pharetra magna eget faucibus cursus. Fusce luctus, augue nec bibendum rutrum, leo enim lacinia nisl, ut rhoncus dolor lorem at nibh. In sed eleifend arcu. Etiam porttitor ultrices cursus. Maecenas ac fringilla lacus. Etiam eu congue erat, sed auctor tellus. Sed lobortis faucibus malesuada. Integer lacinia, nunc et efficitur ornare, diam felis porttitor turpis, eu ultrices arcu orci nec diam. Mauris sit amet metus vel lorem scelerisque mattis nec at tortor.

        Proin ut lectus a velit laoreet molestie eget eu nunc. Integer eu dictum metus, quis pretium risus. Vestibulum pellentesque venenatis posuere. Donec tincidunt hendrerit elit nec blandit. Nullam ut arcu non nunc tempus fermentum vitae at massa. Aenean faucibus leo libero, eget porttitor urna porta eu. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.

        Sed id consequat dolor, mollis congue nisl. Duis egestas fermentum elit ut porttitor. Etiam non mi mauris. Ut suscipit lorem commodo ante facilisis, pellentesque condimentum orci tempus. Phasellus tristique varius mauris, nec pulvinar velit ultrices at. Cras et congue lectus. Nam feugiat eu lacus id aliquam. Integer sit amet tincidunt metus, scelerisque vulputate nisi. Suspendisse consectetur lorem non velit vulputate, ut aliquet diam rhoncus. Aliquam lacinia vulputate eleifend.

        Morbi sapien ipsum, consectetur in vehicula non, pellentesque ac quam. Ut ornare sollicitudin elementum. Praesent ac orci molestie, semper diam vel, consequat tellus. Praesent sagittis turpis in nisl mattis auctor. Maecenas quam elit, ullamcorper at turpis quis, pharetra elementum mi. Sed pretium facilisis nulla, sed facilisis justo rhoncus nec. Phasellus id lacus tellus. Cras vehicula arcu elit, ut lacinia lectus euismod a. Aenean id risus congue, sodales orci vel, scelerisque enim. Nunc accumsan gravida est, eu pulvinar urna vehicula id.

        Nunc ullamcorper ipsum sit amet felis viverra, eget consectetur orci tincidunt. Mauris leo tortor, semper nec quam vel, tincidunt faucibus justo. Vivamus viverra ipsum non enim pharetra dignissim. Etiam id viverra ex. Donec tristique metus orci, sed condimentum sapien aliquam at. Integer pellentesque, turpis ut posuere eleifend, neque orci consequat odio, eget sollicitudin nibh urna in orci. Praesent posuere velit ullamcorper, faucibus dui et, suscipit ante. Sed efficitur et dolor id elementum. Nunc consectetur aliquam dictum. Phasellus in dolor id neque pharetra iaculis eu ut quam. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Morbi egestas turpis risus, a blandit nulla venenatis quis.
    </p>
  </div>
  <div class="column" style="background-color:#00FFFF;">
    <h2>Column 2</h2>
    <p>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur a elementum nulla. Mauris gravida, felis in cursus malesuada, libero est ultricies neque, tempus ultrices orci magna sed justo. Quisque laoreet aliquet elit vel tincidunt. Proin vitae consequat quam. Nullam ac rhoncus orci. Nullam pharetra magna eget faucibus cursus. Fusce luctus, augue nec bibendum rutrum, leo enim lacinia nisl, ut rhoncus dolor lorem at nibh. In sed eleifend arcu. Etiam porttitor ultrices cursus. Maecenas ac fringilla lacus. Etiam eu congue erat, sed auctor tellus. Sed lobortis faucibus malesuada. Integer lacinia, nunc et efficitur ornare, diam felis porttitor turpis, eu ultrices arcu orci nec diam. Mauris sit amet metus vel lorem scelerisque mattis nec at tortor.

        Proin ut lectus a velit laoreet molestie eget eu nunc. Integer eu dictum metus, quis pretium risus. Vestibulum pellentesque venenatis posuere. Donec tincidunt hendrerit elit nec blandit. Nullam ut arcu non nunc tempus fermentum vitae at massa. Aenean faucibus leo libero, eget porttitor urna porta eu. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.

        Sed id consequat dolor, mollis congue nisl. Duis egestas fermentum elit ut porttitor. Etiam non mi mauris. Ut suscipit lorem commodo ante facilisis, pellentesque condimentum orci tempus. Phasellus tristique varius mauris, nec pulvinar velit ultrices at. Cras et congue lectus. Nam feugiat eu lacus id aliquam. Integer sit amet tincidunt metus, scelerisque vulputate nisi. Suspendisse consectetur lorem non velit vulputate, ut aliquet diam rhoncus. Aliquam lacinia vulputate eleifend.

        Morbi sapien ipsum, consectetur in vehicula non, pellentesque ac quam. Ut ornare sollicitudin elementum. Praesent ac orci molestie, semper diam vel, consequat tellus. Praesent sagittis turpis in nisl mattis auctor. Maecenas quam elit, ullamcorper at turpis quis, pharetra elementum mi. Sed pretium facilisis nulla, sed facilisis justo rhoncus nec. Phasellus id lacus tellus. Cras vehicula arcu elit, ut lacinia lectus euismod a. Aenean id risus congue, sodales orci vel, scelerisque enim. Nunc accumsan gravida est, eu pulvinar urna vehicula id.

        Nunc ullamcorper ipsum sit amet felis viverra, eget consectetur orci tincidunt. Mauris leo tortor, semper nec quam vel, tincidunt faucibus justo. Vivamus viverra ipsum non enim pharetra dignissim. Etiam id viverra ex. Donec tristique metus orci, sed condimentum sapien aliquam at. Integer pellentesque, turpis ut posuere eleifend, neque orci consequat odio, eget sollicitudin nibh urna in orci. Praesent posuere velit ullamcorper, faucibus dui et, suscipit ante. Sed efficitur et dolor id elementum. Nunc consectetur aliquam dictum. Phasellus in dolor id neque pharetra iaculis eu ut quam. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Morbi egestas turpis risus, a blandit nulla venenatis quis.

        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur a elementum nulla. Mauris gravida, felis in cursus malesuada, libero est ultricies neque, tempus ultrices orci magna sed justo. Quisque laoreet aliquet elit vel tincidunt. Proin vitae consequat quam. Nullam ac rhoncus orci. Nullam pharetra magna eget faucibus cursus. Fusce luctus, augue nec bibendum rutrum, leo enim lacinia nisl, ut rhoncus dolor lorem at nibh. In sed eleifend arcu. Etiam porttitor ultrices cursus. Maecenas ac fringilla lacus. Etiam eu congue erat, sed auctor tellus. Sed lobortis faucibus malesuada. Integer lacinia, nunc et efficitur ornare, diam felis porttitor turpis, eu ultrices arcu orci nec diam. Mauris sit amet metus vel lorem scelerisque mattis nec at tortor.

        Proin ut lectus a velit laoreet molestie eget eu nunc. Integer eu dictum metus, quis pretium risus. Vestibulum pellentesque venenatis posuere. Donec tincidunt hendrerit elit nec blandit. Nullam ut arcu non nunc tempus fermentum vitae at massa. Aenean faucibus leo libero, eget porttitor urna porta eu. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.

        Sed id consequat dolor, mollis congue nisl. Duis egestas fermentum elit ut porttitor. Etiam non mi mauris. Ut suscipit lorem commodo ante facilisis, pellentesque condimentum orci tempus. Phasellus tristique varius mauris, nec pulvinar velit ultrices at. Cras et congue lectus. Nam feugiat eu lacus id aliquam. Integer sit amet tincidunt metus, scelerisque vulputate nisi. Suspendisse consectetur lorem non velit vulputate, ut aliquet diam rhoncus. Aliquam lacinia vulputate eleifend.

        Morbi sapien ipsum, consectetur in vehicula non, pellentesque ac quam. Ut ornare sollicitudin elementum. Praesent ac orci molestie, semper diam vel, consequat tellus. Praesent sagittis turpis in nisl mattis auctor. Maecenas quam elit, ullamcorper at turpis quis, pharetra elementum mi. Sed pretium facilisis nulla, sed facilisis justo rhoncus nec. Phasellus id lacus tellus. Cras vehicula arcu elit, ut lacinia lectus euismod a. Aenean id risus congue, sodales orci vel, scelerisque enim. Nunc accumsan gravida est, eu pulvinar urna vehicula id.

        Nunc ullamcorper ipsum sit amet felis viverra, eget consectetur orci tincidunt. Mauris leo tortor, semper nec quam vel, tincidunt faucibus justo. Vivamus viverra ipsum non enim pharetra dignissim. Etiam id viverra ex. Donec tristique metus orci, sed condimentum sapien aliquam at. Integer pellentesque, turpis ut posuere eleifend, neque orci consequat odio, eget sollicitudin nibh urna in orci. Praesent posuere velit ullamcorper, faucibus dui et, suscipit ante. Sed efficitur et dolor id elementum. Nunc consectetur aliquam dictum. Phasellus in dolor id neque pharetra iaculis eu ut quam. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Morbi egestas turpis risus, a blandit nulla venenatis quis.
    </p>
  </div>
</div>

</div>
</body>

</html>
