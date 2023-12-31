<?php
/*
 * crowdsec_status.php
 *
 * part of pfSense (https://www.pfsense.org)
 * Copyright (c) 2020-2023 Crowdsec
 * All rights reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

require_once("guiconfig.inc");
require_once("globals.inc");


$g['disablehelpicon'] = true;

$pgtitle = array(gettext("Security"), gettext("CrowdSec"), gettext("Metrics"));
$pglinks = ['@self', '@self', '@self'];
$shortcut_section = "crowdsec";

include("head.inc");

$tab_array = array();
$tab_array[] = array("Read me", false, "/crowdsec_landing.php");
$tab_array[] = array("Settings", false, "/pkg_edit.php?xml=crowdsec.xml&amp;id=0");
$tab_array[] = array("Status", false, "/crowdsec_status.php");
$tab_array[] = array("Metrics", true, "/crowdsec_metric.php");
display_top_tabs($tab_array);

$css = <<<EOT
<style type="text/css">
.search .fa-search {
  font-weight: bolder !important;
}
.no-results {
 display:none !important;
}

.loading {
text-align:center;
padding: 4rem;
}

.table td {
  white-space: break-spaces;
  word-break: break-all;
}

.content-box table {
  table-layout: auto;
}

table.bootgrid-table tr .btn-sm {
  padding: 2px 6px;
}

table.bootgrid-table tr > td {
  padding: 3px;
}

li.spaced {
  margin-left: 15px;
}

ul.nav>li>a {
  padding: 6px;
}


</style>
EOT;


$content = <<<EOT
  <link rel="stylesheet" href="/crowdsec/css/jquery.bootgrid.min.css">
  <script src="/crowdsec/js/jquery.bootgrid.min.js" defer></script>
  <script src="/crowdsec/js/jquery.bootgrid.fa.min.js" defer></script>
  <script src="/crowdsec/js/moment.min.js" defer></script>
  <script src="/crowdsec/js/crowdsec.js" defer></script>
    <script>
    events.push(function() {
         CrowdSec.initMetrics();
         $('#tabs').show();
    });
    </script>

<div id="tabs" style="display:none;">
  <ul>
    <li><a href="#tab-metrics-acquisition">Acquisition</a></li>
    <li><a href="#tab-metrics-bucket">Bucket</a></li>
    <li><a href="#tab-metrics-parser">Parser</a></li>
    <li><a href="#tab-metrics-lapi">Local API</a></li>
    <li><a href="#tab-metrics-lapi-machines">Local API machines</a></li>
    <li><a href="#tab-metrics-lapi-bouncers">Local API bouncers</a></li>
    <li><a href="#tab-metrics-lapi-decisions">Local API decisions</a></li>
    <li><a href="#tab-metrics-lapi-alerts">Local API alerts</a></li>
  </ul>
  <div class="loading"><i class="fa fa-spinner fa-spin"></i>Loading, please wait..</div>
  <div id="tab-metrics-acquisition">
    <table id="table-metrics-acquisition" class="table table-condensed table-hover table-striped crowdsecTable">
            <thead>
                <tr>
                  <th data-column-id="source">Source</th>
                  <th data-column-id="read" data-type="numeric">Lines read</th>
                  <th data-column-id="parsed" data-type="numeric">Lines parsed</th>
                  <th data-column-id="unparsed" data-type="numeric">Lines unparsed</th>
                  <th data-column-id="poured" data-type="numeric">Lines poured to bucket</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
                <tr>
                </tr>
            </tfoot>
        </table>
  </div>
  <div id="tab-metrics-bucket">
   <table id="table-metrics-bucket" class="table table-condensed table-hover table-striped crowdsecTable">
        <thead>
            <tr>
              <th data-column-id="bucket">Bucket</th>
              <th data-column-id="overflows" data-type="numeric">Overflows</th>
             <th data-column-id="instantiated" data-type="numeric">Instantiated</th>
             <th data-column-id="poured" data-type="numeric">Poured</th>
             <th data-column-id="underflows" data-type="numeric">Underflows</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot>
            <tr>
            </tr>
        </tfoot>
    </table>
  </div>
  <div id="tab-metrics-parser">
    <table id="table-metrics-parser" class="table table-condensed table-hover table-striped crowdsecTable">
        <thead>
            <tr>
              <th data-column-id="parsers">Parsers</th>
              <th data-column-id="hits" data-type="numeric">Hits</th>
              <th data-column-id="parsed" data-type="numeric">parsed</th>
              <th data-column-id="unparsed" data-type="numeric">Unparsed</th>
            </tr>
        </thead>
        <tbody>
         </tbody>
        <tfoot>
            <tr>
            </tr>
        </tfoot>
    </table>
  </div>
  <div id="tab-metrics-lapi">
     <table id="table-metrics-lapi" class="table table-condensed table-hover table-striped crowdsecTable">
        <thead>
            <tr>
              <th data-column-id="route">Route</th>
              <th data-column-id="method">Method</th>
              <th data-column-id="hits" data-type="numeric">Hits</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot>
            <tr>
            </tr>
        </tfoot>
    </table>
  </div>
  <div id="tab-metrics-lapi-machines">
      <table id="table-metrics-lapi-machines" class="table table-condensed table-hover table-striped crowdsecTable">
        <thead>
            <tr>
              <th data-column-id="machine">Machine</th>
              <th data-column-id="route">Route</th>
              <th data-column-id="method">Method</th>
              <th data-column-id="hits" data-type="numeric">Hits</th>
            </tr>
        </thead>
        <tbody>
            </tbody>
        <tfoot>
            <tr>
            </tr>
        </tfoot>
    </table>
  </div>
  <div id="tab-metrics-lapi-bouncers">
      <table id="table-metrics-lapi-bouncers" class="table table-condensed table-hover table-striped crowdsecTable">
            <thead>
                <tr>
                  <th data-column-id="bouncer">Bouncer</th>
                   <th data-column-id="route">Route</th>
                    <th data-column-id="method">Method</th>
                    <th data-column-id="hits" data-type="numeric">Hits</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
                <tr>
                </tr>
            </tfoot>
        </table>
  </div>
  <div id="tab-metrics-lapi-decisions">
    <table id="table-metrics-lapi-decisions" class="table table-condensed table-hover table-striped crowdsecTable">
        <thead>
            <tr>
              <th data-column-id="reason">Reason</th>
              <th data-column-id="origin">Origin</th>
              <th data-column-id="action">Action</th>
              <th data-column-id="count">Count</th>
            </tr>
        </thead>
       <tbody>
        </tbody>
        <tfoot>
            <tr>
            </tr>
        </tfoot>
    </table>
  </div>
  <div id="tab-metrics-lapi-alerts">
    <table id="table-metrics-lapi-alerts" class="table table-condensed table-hover table-striped crowdsecTable">
            <thead>
                <tr>
                 <th data-column-id="reason">Reason</th>
                 <th data-column-id="count" data-type="numeric">Count</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
                <tr>
                </tr>
            </tfoot>
        </table>
  </div>
</div>
EOT;


echo $content;

echo $css;


include("foot.inc");
