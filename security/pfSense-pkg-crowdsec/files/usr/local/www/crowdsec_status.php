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

$pgtitle = array(gettext("Security"), gettext("CrowdSec"), gettext("Status"));
$pglinks = ['@self', '@self', '@self'];
$shortcut_section = "crowdsec";

include("head.inc");

$tab_array = array();
$tab_array[] = array("Read me", false, "/crowdsec_landing.php");
$tab_array[] = array("Settings", false, "/pkg_edit.php?xml=crowdsec.xml&amp;id=0");
$tab_array[] = array("Status", true, "/crowdsec_status.php");
$tab_array[] = array("Metrics", false, "/crowdsec_metric.php");
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

#decisions-disclaimer {
border: 1px solid #000000;
padding: 10px 10px 0px 10px;
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
         CrowdSec.initStatus();
         $('#tabs').show();
    });
    </script>

<div id="tabs" style="display:none;">
  <ul>
    <li><a href="#tab-status-machines">Machines</a></li>
    <li><a href="#tab-status-bouncers">Bouncers</a></li>
    <li><a href="#tab-status-collections">Collections</a></li>
    <li><a href="#tab-status-scenarios">Scenarios</a></li>
    <li><a href="#tab-status-parsers">Parsers</a></li>
    <li><a href="#tab-status-postoverflows">Postoverflows</a></li>
    <li><a href="#tab-status-alerts">Alerts</a></li>
    <li><a href="#tab-status-decisions">Decisions</a></li>
  </ul>
  <div class="loading"><i class="fa fa-spinner fa-spin"></i>Loading, please wait..</div>
  <div id="tab-status-machines">
    <table id="table-status-machines" class="table table-condensed table-hover table-striped crowdsecTable">
            <thead>
                <tr>
                  <th data-column-id="name">Name</th>
                  <th data-column-id="ip_address">IP Address</th>
                  <th data-column-id="last_update" data-formatter="datetime">Last Update</th>
                  <th data-column-id="validated" data-formatter="yesno" data-searchable="false">Validated?</th>
                  <th data-column-id="version">Version</th>
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
  <div id="tab-status-bouncers">
   <table id="table-status-bouncers" class="table table-condensed table-hover table-striped crowdsecTable">
        <thead>
            <tr>
              <th data-column-id="name">Name</th>
              <th data-column-id="ip_address">IP Address</th>
              <th data-column-id="valid" data-formatter="yesno" data-searchable="false">Valid</th>
              <th data-column-id="last_pull" data-formatter="datetime">Last API Pull</th>
              <th data-column-id="type">Type</th>
              <th data-column-id="version">Version</th>
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
  <div id="tab-status-collections">
    <table id="table-status-collections" class="table table-condensed table-hover table-striped crowdsecTable">
        <thead>
            <tr>
              <th data-column-id="name">Name</th>
              <th data-column-id="status">Status</th>
              <th data-column-id="local_version">Version</th>
              <th data-column-id="local_path">Local Path</th>
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
  <div id="tab-status-scenarios">
     <table id="table-status-scenarios" class="table table-condensed table-hover table-striped crowdsecTable">
        <thead>
            <tr>
              <th data-column-id="name">Name</th>
              <th data-column-id="status">Status</th>
              <th data-column-id="local_version">Version</th>
              <th data-column-id="local_path">Path</th>
              <th data-column-id="description">Description</th>
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
  <div id="tab-status-parsers">
      <table id="table-status-parsers" class="table table-condensed table-hover table-striped crowdsecTable">
        <thead>
            <tr>
              <th data-column-id="name">Name</th>
              <th data-column-id="status">Status</th>
              <th data-column-id="local_version">Version</th>
              <th data-column-id="local_path">Local Path</th>
              <th data-column-id="description">Description</th>
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
  <div id="tab-status-postoverflows">
      <table id="table-status-postoverflows" class="table table-condensed table-hover table-striped crowdsecTable">
            <thead>
                <tr>
                  <th data-column-id="name">Name</th>
                  <th data-column-id="status">Status</th>
                  <th data-column-id="local_version">Version</th>
                  <th data-column-id="local_path">Local Path</th>
                  <th data-column-id="description">Description</th>
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
  <div id="tab-status-alerts">
    <table id="table-status-alerts" class="table table-condensed table-hover table-striped crowdsecTable">
        <thead>
            <tr>
              <th data-column-id="id" data-type="numeric">ID</th>
              <th data-column-id="value">Value</th>
              <th data-column-id="reason">Reason</th>
              <th data-column-id="country">Country</th>
              <th data-column-id="as">AS</th>
              <th data-column-id="decisions">Decisions</th>
              <th data-column-id="created_at" data-formatter="datetime">Created At</th>
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
  <div id="tab-status-decisions">
    <table id="table-status-decisions" class="table table-condensed table-hover table-striped crowdsecTable">
    <div id="decisions-disclaimer"><p>Note: the decisions coming from the CAPI (signals collected by the CrowdSec users)
     do not appear here.
        To show them, use <code>cscli decisions list -a</code> in a shell.</p>
        </div>
            <thead>
                <tr>
                  <th data-column-id="delete" data-formatter="delete" 
                  data-visible-in-selection="false"></th>
                  <th data-column-id="id" data-identifier="true" data-type="numeric">ID</th>
                  <th data-column-id="source">Source</th>
                  <th data-column-id="scope_value">Scope:Value</th>
                  <th data-column-id="reason">Reason</th>
                  <th data-column-id="action">Action</th>
                  <th data-column-id="country">Country</th>
                  <th data-column-id="as">AS</th>
                  <th data-column-id="events_count" data-type="numeric">Events</th>
                  <th data-column-id="expiration" data-formatter="duration">Expiration</th>
                  <th data-column-id="alert_id" data-type="numeric">Alert&nbsp;ID</th>
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
<!-- Modal popup to confirm decision deletion -->
<div class="modal fade" id="remove-decision-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" 
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="modalLabel">Modal Title</h4>
            </div>
            <div class="modal-body">
                Modal content...
            </div>
            <div class="modal-footer">
                <button type="button" class="nowarn no-confirm btn btn-secondary" data-dismiss="modal">No, 
                cancel</button>
                <button type="button" class="nowarn no-confirm btn btn-danger" data-dismiss="modal" 
                id="remove-decision-confirm">Yes, 
                delete</button>
            </div>
        </div>
    </div>
</div>
EOT;


echo $content;

echo $css;


include("foot.inc");
