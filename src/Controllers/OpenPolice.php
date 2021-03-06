<?php
/**
  * OpenPolice the core top-level class for which extends both SurvLoop,
  * and most functions specific to OpenPolice.org.
  *
  * OpenPolice.org
  * @package  flexyourrights/openpolice
  * @author  Morgan Lesko <rockhoppers@runbox.com>
  * @since  v0.0.1
  */
namespace OpenPolice\Controllers;

use DB;
use Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\OPPersonContact;
use App\Models\OPPhysicalDesc;
use OpenPolice\Controllers\OpenDashAdmin;
use OpenPolice\Controllers\OpenInitExtras;

class OpenPolice extends OpenInitExtras
{
    /**
     * Overrides primary SurvLoop printing of individual nodes from 
     * surveys and site pages. This is one of the main routing hubs
     * for OpenPolice.org customizations beyond SurvLoop defaults.
     *
     * @param  int $nID
     * @param  array $tmpSubTier
     * @param  string $nIDtxt
     * @param  string $nSffx
     * @param  int $currVisib
     * @return string
     */
    protected function customNodePrint($nID = -3, $tmpSubTier = [], $nIDtxt = '', $nSffx = '', $currVisib = 1)
    {
        // Main Complaint Survey
        if (in_array($nID, [145, 920])) {
            return $this->printDeptSearch($nID);
        } elseif ($nID == 416) {
            $this->cleanDeptLnks();
        } elseif ($nID == 203) {
            $this->initBlnkAllegsSilv();
        } elseif ($nID == 2341) {
            return $this->printAllegAudit();
        } elseif (in_array($nID, [270, 973])) {
            return $this->printEndOfComplaintRedirect($nID);
            
        // Home Page
        } elseif ($nID == 1876) {
            return view('vendor.openpolice.nodes.1876-home-page-hero-credit')->render();
        } elseif ($nID == 2685) { // overwrite preview results
            $GLOBALS["SL"]->x["isHomePage"] = true;
            $GLOBALS["SL"]->x["isPublicList"] = true;
            $GLOBALS["SL"]->pageView = 'public';
            return $this->printComplaintListing($nID);
        //} elseif ($nID == 1848) {
        //    return view('vendor.openpolice.nodes.1848-home-page-disclaimer-bar')->render();
                
        // FAQ
        } elseif ($nID == 1884) {
            $GLOBALS["SL"]->addBodyParams('onscroll="if (typeof bodyOnScroll === \'function\') bodyOnScroll();"');
            
        // Public Departments Accessibility Overview
        } elseif ($nID == 1968) {
            return $this->printDeptAccScoreTitleDesc($nID);
        } elseif ($nID == 1816) {
            return $this->printDeptAccScoreBars($nID);
        } elseif (in_array($nID, [1863, 1858, 2013])) {
            return $this->publicDeptAccessMap($nID);
            
        } elseif ($nID == 1907) { // Donate Social Media Buttons
            return view('vendor.openpolice.nodes.1907-donate-share-social')->render();
        } elseif (in_array($nID, [859, 1454])) {
            return $this->printDeptOverPublic($nID);
        } elseif (in_array($nID, [2804])) {
            return $this->printDeptOverPublicTop50s($nID);
                
        // How We Rate Departments Page
        } elseif ($nID == 1127) {
            foreach ([1827, 1825, 1829, 1831, 1833, 1837, 1806, 1835, 1, 2, 3, 4, 5, 6, 7] as $n) {
                $GLOBALS["SL"]->addHshoo('/how-we-rate-departments#n' . $n);
            }
            
        // Department Profile
        } elseif ($nID == 1779) {
            return $this->printDeptComplaints($nID);
        } elseif ($nID == 2706) {
            return $this->printDeptHeaderLoad($nID);
        } elseif ($nID == 2711) {
            return $this->printBasicDeptInfo($nID);
        } elseif ($nID == 2713) {
            return $this->printDeptCallsToAction($nID);
        } elseif ($nID == 2715) {
            return $this->printDeptReportsRecent($nID);
        } elseif ($nID == 2717) {
            return $this->printDeptProfileAccScore($nID);
        } elseif ($nID == 2718) {
            return $this->printDeptProfileHowToFile($nID);
        } elseif ($nID == 2720) {
            return $this->printDeptOfficerComplaints();


            
        // Partner Profiles
        } elseif ($nID == 2179) {
            return $this->printPartnersOverviewPublic($nID);
        } elseif ($nID == 1896) {
            return $this->printAttorneyReferrals($nID);
        } elseif (in_array($nID, [1961, 2062])) {
            return $this->publicPartnerHeader($nID);
        } elseif (in_array($nID, [1898, 2060])) {
            return $this->publicPartnerPage($nID);
        } elseif (in_array($nID, [2115, 2069])) {
            return $this->printPreparePartnerHeader($nID);
        } elseif ($nID == 2677) {
            return $this->publicPartnerPageClinicOnly($nID);
               
        // User Profile
        } elseif ($nID == 1893) {
            return $this->printProfileMyComplaints($nID);
            
        // Complaint Report Tools
        } elseif ($nID == 1712) {
            return $this->printComplaintAdmin();
        } elseif ($nID == 1713) {
            return $this->printComplaintOversight();
        } elseif ($nID == 1714) {
            return $this->printComplaintOwner();
        } elseif ($nID == 1780) {
            return $this->printMfaInstruct();

        // Complaint Report
        } elseif ($nID == 1374) {
            return $this->reportAllegsWhy($nID);
        } elseif ($nID == 1373) {
            return $this->reportStory($nID);
        } elseif (in_array($nID, [2330, 2332])) {
            return $this->chkGetReportDept($this->sessData->getLatestDataBranchID());
        } elseif (in_array($nID, [1382, 1734])) {
            return $this->getReportDept($this->sessData->getLatestDataBranchID());
        } elseif ($nID == 1690) {
            return $this->getReportByLine();
        } elseif ($nID == 1687) {
            return $this->getReportWhenLine();
        } elseif (in_array($nID, [1688, 1732])) {
            return $this->getReportWhereLine($nID);
        } elseif ($nID == 1691) {
            return [
                'Privacy Setting', 
                $this->getReportPrivacy($nID)
            ];
        } elseif ($nID == 1468) {
            return $this->getCivReportNameHeader($nID);
        } elseif (in_array($nID, [1505, 2637, 1506, 1507])) {
            return $this->getCivReportNameRow($nID);

        } elseif ($nID == 1476) {
            return $this->getOffReportNameHeader($nID);
        } elseif ($nID == 1478) {
            $civID = $this->sessData->getLatestDataBranchID();
            return [ $this->getCivSnstvFldsNotPrinted($civID) ];
        } elseif ($nID == 1511) {
            return $this->reportCivAddy($nID);
        } elseif ($nID == 1519) {
            $civID = $this->sessData->getLatestDataBranchID();
            return [ $this->getOffSnstvFldsNotPrinted($civID) ];
        } elseif ($nID == 1566) {
            return $this->getOffProfan();
        } elseif ($nID == 1567) {
            return $this->getCivProfan();
        } elseif ($nID == 1891) {
            return $this->getReportOffAge($nID);
        } elseif ($nID == 1574) {
            return $this->reportEventTitle($this->sessData->getLatestDataBranchID());
        } elseif ($nID == 1710) {
            return $this->printReportShare();
        } elseif (in_array($nID, [1795, 2266, 2335])) {
            return $this->getReportUploads($nID);
        } elseif ($nID == 1707) {
            return $this->printGlossary();
        } elseif ($nID == 1753) {
            return $this->printFlexVids();
        } elseif ($nID == 1708) {
            return $this->printFlexArts();
        } elseif ($nID == 2164) {
            return $this->printComplaintSessPath();
        } elseif ($nID == 2632) {
            $this->saveComplaintAdmin();
        } elseif ($nID == 2633) {
            $this->saveComplaintOversight();
        } elseif ($nID == 2634) {
            $this->processOwnerUpdate();
        } elseif (in_array($nID, [2635, 2378])) {
            $GLOBALS["SL"]->x["needsWsyiwyg"] = $this->v["needsWsyiwyg"] = true;
            
        // Complaint Listings
        } elseif (in_array($nID, [1418, 2384])) {
            $GLOBALS["SL"]->x["isPublicList"] = false;
            if ($nID == 2384) {
                $GLOBALS["SL"]->x["isPublicList"] = true;
                $GLOBALS["SL"]->pageView = 'public';
            }
            return $this->printComplaintListing($nID);
        } elseif ($nID == 2377) {
            return $this->printComplaintReportForAdmin($nID);

        // Staff Area Nodes
        } elseif ($nID == 1420) {
            return $this->printComplaintListing($nID, 'incomplete');
        } elseif ($nID == 1939) {
            return $this->printPartnersOverview();
        } elseif ($nID == 2169) {
            return $this->printPartnerCapabilitiesOverview();
        } elseif ($nID == 2166) {
            return $this->printManagePartners($nID);
        } elseif ($nID == 2171) {
            return $this->printManagePartners($nID, 'Organization');
        } elseif ($nID == 1924) {
            return $this->initPartnerCaseTypes($nID);
        } elseif ($nID == 2181) {
            if ($this->sessData->dataSets["partners"][0]->part_type 
                == $GLOBALS["SL"]->def->getID('Partner Types', 'Organization')) {
                $GLOBALS["SL"]->setCurrPage('/dash/manage-organizations');
            } else {
                $GLOBALS["SL"]->setCurrPage('/dash/manage-attorneys');
            }
        } elseif ($nID == 2234) {
            return $this->printBetaTesters($nID);
            
        // Volunteer Area Nodes
        } elseif ($nID == 1211) {
            return $this->printVolunPriorityList();
        } elseif ($nID == 1755) {
            return $this->printVolunAllList();
        } elseif ($nID == 1217) {
            return $this->printVolunLocationForm();
        } elseif ($nID == 1225) {
            return $this->printDeptEditHeader();
        } elseif ($nID == 2162) {
            return $this->printDeptEditHeader2();
        } elseif ($nID == 1261) {
            return view(
                'vendor.openpolice.nodes.1261-volun-dept-edit-wiki-stats', 
                $this->v
            )->render();
        } elseif ($nID == 1809) {
            return view(
                'vendor.openpolice.nodes.1809-volun-dept-edit-how-investigate', 
                $this->v
            )->render();
        } elseif ($nID == 1227) {
            return view(
                'vendor.openpolice.nodes.1227-volun-dept-edit-search-complaint', 
                $this->v
            )->render();
        } elseif ($nID == 1231) {
            return view(
                'vendor.openpolice.volun.volun-dept-edit-history', 
                $this->v
            )->render();
        } elseif ($nID == 1338) {
            return $GLOBALS["SL"]->getBlurbAndSwap('Volunteer Checklist');
        } elseif ($nID == 1340) {
            return $this->redirAfterDeptEdit();
        } elseif ($nID == 1344) {
            return $this->redirNextDeptEdit();
        } elseif ($nID == 1346) {
            return $this->volunStars();
        } elseif ($nID == 1351) {
            $this->initAdmDash();
            return $this->v["openDash"]->volunDepts();
            
        // Admin Dashboard Page
        } elseif ($nID == 2345) {
            $this->initAdmDash();
            return $this->v["openDash"]->printDashTopLevStats();
        } elseif ($nID == 1359) {
            $this->initAdmDash();
            return $this->v["openDash"]->printDashSessGraph();
        } elseif ($nID == 1342) {
            $this->initAdmDash();
            return $this->v["openDash"]->printDashPercCompl();
        } elseif ($nID == 1361) {
            $this->initAdmDash();
            return $this->v["openDash"]->printDashTopStats();
        } elseif ($nID == 1349) {
            $this->initAdmDash();
            return $this->v["openDash"]->volunStatsDailyGraph();
        } elseif ($nID == 2100) {
            $this->initAdmDash();
            return $this->v["openDash"]->volunStatsTable();
            
        // Software Development Area
        } elseif (in_array($nID, [2690, 2703, 2297, 2759, 2317])) {
            return $this->printNavDevelopmentArea($nID);

        }
        return '';
    }
    
    /**
     * Overrides default SurvLoop behavior for responses to multiple-choice questions.
     *
     * @param  int $nID
     * @param  SLNode &$curr
     * @return SLNode
     */
    protected function customResponses($nID, &$curr)
    {
        if ($nID == 2126) {
            if (isset($curr->responses[0]) && isset($curr->responses[0]->node_res_eng) 
                && isset($this->sessData->dataSets["complaints"]) 
                && isset($this->sessData->dataSets["complaints"][0]->com_privacy)) {
                switch ($this->sessData->dataSets["complaints"][0]->com_privacy) {
                    case $GLOBALS["SL"]->def->getID('Privacy Types', 'Submit Publicly'):
                        $curr->responses[0]->node_res_eng = 'Yes, I agree to publish my complaint data on this website 
                            with <b>Full Transparency</b>.<div class="pL20 mL5 mT10">
                            We will publish your FULL complaint on OpenPolice.org. This includes your written story, 
                            the names of civilians and police officers, and all survey answers.
                            </div>';
                        break;
                    case $GLOBALS["SL"]->def->getID('Privacy Types', 'Names Visible to Police but not Public'):
                        $curr->responses[0]->node_res_eng = 'Yes, I agree to publish my complaint data on this website 
                            with <b>No Names Public</b>.<div class="pL20 mL5 mT10">
                            Only your multiple-choice answers will be published on OpenPolice.org. 
                            This will NOT include your written story or police officers\' names and badge numbers.
                            </div>';
                        break;
                    case $GLOBALS["SL"]->def->getID('Privacy Types', 'Completely Anonymous'):
                    case $GLOBALS["SL"]->def->getID('Privacy Types', 'Anonymized'):
                        $curr->responses[0]->node_res_eng = 'Yes, I agree to publish my <b>Anonymized</b> 
                            complaint data on this website.<div class="pL20 mL5 mT10">
                            Only your multiple-choice answers will be published on OpenPolice.org. 
                            This will NOT include your written story or police officers\' names and badge numbers.
                            </div>';
                        break;
                }
            }
        }
        return $curr;
    }
    
    /**
     * Initializes the admin dashboard side-class.
     *
     * @return boolean
     */
    protected function initAdmDash()
    {
        $this->v["isDash"] = true;
        if (!isset($this->v["openDash"])) {
            $this->v["openDash"] = new OpenDashAdmin;
        }
        return true;
    }
    
    /**
     * Overrides or disables the default printing of survey Back/Next buttons.
     *
     * @param  int $nID
     * @param  string $promptNotes
     * @return string
     */
    protected function customNodePrintButton($nID = -3, $promptNotes = '')
    { 
        if (in_array($nID, [270, 973])) {
            return '<!-- no buttons, all done! -->';
        }
        return '';
    }
    
    /**
     * Look up the person contact record and physical description record
     * for a civilian or officer.
     *
     * @return boolean
     */
    protected function chkPersonRecs()
    {
        // This should've been automated via the data table subset option
        // but for now, I'm replacing that complication with this check...
        $found = false;
        $types = [
            ['civilians', 'civ'],
            ['officers',  'off']
        ];
        foreach ($types as $type) {
            if (isset($this->sessData->dataSets[$type[0]]) 
                && sizeof($this->sessData->dataSets[$type[0]]) > 0) {
                foreach ($this->sessData->dataSets[$type[0]] as $i => $civ) {
                    if (!isset($civ->{ $type[1] . '_person_id' }) 
                        || intVal($civ->{ $type[1] . '_person_id' }) <= 0) {
                        $new = new OPPersonContact;
                        $new->save();
                        $this->sessData->dataSets[$type[0]][$i]->update([
                            $type[1] . '_person_id' => $new->getKey() 
                        ]);
                        $found = true;
                    }
                    if (!isset($civ->{ $type[1] . '_phys_desc_id' }) 
                        || intVal($civ->{ $type[1] . '_phys_desc_id' }) <= 0) {
                        $new = new OPPhysicalDesc;
                        $new->save();
                        $this->sessData->dataSets[$type[0]][$i]->update([
                            $type[1] . '_phys_desc_id' => $new->getKey()
                        ]);
                        $found = true;
                    }
                }
            }
        }
        if ($found) {
            $this->sessData->refreshDataSets();
        }
        // // // //
        return true;
    }
    
    /**
     * Look up the record linking fields which should be skipped
     * when auto-creating a new loop item's database record.
     *
     * @return array
     */
    protected function newLoopItemSkipLinks($tbl = '')
    {
        // Until this can be auto-inferred for 
        // outgoing linkages to data subsets
        if ($tbl == 'civilians') {
            return [ 'civ_person_id', 'civ_phys_desc_id' ];
        } elseif ($tbl == 'officers') {
            return [ 'off_person_id', 'off_phys_desc_id' ];
        }
        return [];
    }
    
    /**
     * Double-check behavior after a new item has been created for a data loop.
     *
     * @param  string $tbl
     * @param  int $itemID
     * @return boolean
     */
    protected function afterCreateNewDataLoopItem($tbl = '', $itemID = -3)
    {
        if (in_array($tbl, ['civilians', 'officers']) && $itemID > 0) {
            $this->chkPersonRecs();
        }
        return true;
    }
    
    /**
     * Print warning message for uploading tool.
     *
     * @param  int $nID
     * @return string
     */
    protected function uploadWarning($nID)
    {
        return 'WARNING: If documents show sensitive personal information, set this to "private." 
            This includes addresses, phone numbers, emails, or social security numbers.';
    }
    
}