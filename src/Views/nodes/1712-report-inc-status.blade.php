<!-- resources/views/vendor/openpolice/nodes/1712-report-inc-status.blade.php -->
<option value="Hold: Go Gold" @if (!$firstReview && isset($lastReview->com_rev_status) 
    && trim($lastReview->com_rev_status) == 'Hold: Go Gold') SELECTED @endif 
    >Invite To Go Gold (On Hold)</option>
<option value="Needs More Work" @if (!$firstReview && isset($lastReview->com_rev_status) 
    && trim($lastReview->com_rev_status) == 'Needs More Work') SELECTED @endif 
    >Needs More Work (On Hold)</option>
<option DISABLED ></option>
<option value="Pending Attorney: Needed" @if (!$firstReview && isset($lastReview->com_rev_status) 
    && trim($lastReview->com_rev_status) == 'Pending Attorney: Needed') SELECTED @endif 
    >Defense Attorney Needed (Un-Publish, On Hold)</option>
<option value="Pending Attorney: Hook-Up" @if (!$firstReview && isset($lastReview->com_rev_status) 
    && trim($lastReview->com_rev_status) == 'Pending Attorney: Hook-Up') SELECTED @endif 
    >Civil Rights Attorney Needed (Un-Publish, On Hold)</option>
<option value="Attorney'd" @if (!$firstReview && isset($lastReview->com_rev_status) 
    && trim($lastReview->com_rev_status) == "Attorney'd") SELECTED @endif 
    >Has Attorney (Un-Publish, On Hold)</option>
<option DISABLED ></option>
<option value="OK to Submit to Oversight" @if (!$firstReview && isset($lastReview->com_rev_status) 
    && trim($lastReview->com_rev_status) == 'OK to Submit to Oversight') SELECTED @endif 
    >OK to Submit to Investigative Agency (Reviewed)</option>
<option value="Submitted to Oversight" @if (!$firstReview && isset($lastReview->com_rev_status) 
    && trim($lastReview->com_rev_status) == 'Submitted to Oversight') SELECTED @endif 
    >Submitted to Investigative Agency (Full Transparency Public)</option>
<option value="Received by Oversight" @if (!$firstReview && isset($lastReview->com_rev_status) 
    && trim($lastReview->com_rev_status) == 'Received by Oversight') SELECTED @endif 
    >Received by Investigative Agency (Full Transparency Public)</option>
<option value="Pending Oversight Investigation" @if (!$firstReview && isset($lastReview->com_rev_status) 
    && trim($lastReview->com_rev_status) == 'Pending Oversight Investigation') SELECTED @endif 
    >Being Investigated (Full Transparency Public, Presumably)</option>
<option value="Investigated (Closed)" @if (!$firstReview && isset($lastReview->com_rev_status) 
    && trim($lastReview->com_rev_status) == 'Investigated (Closed)') SELECTED @endif 
    >Investigated (Full Transparency Public, Closed)</option>
<option value="Declined To Investigate (Closed)" @if (!$firstReview && isset($lastReview->com_rev_status) 
    && trim($lastReview->com_rev_status) == 'Declined To Investigate (Closed)') SELECTED @endif 
    >Declined To Investigate (Full Transparency Public, Closed)</option>
<option value="Closed" @if (!$firstReview && isset($lastReview->com_rev_status) 
    && trim($lastReview->com_rev_status) == 'Closed') SELECTED @endif 
    >Otherwise Closed (Full Transparency Public, Closed)</option>
<option DISABLED ></option>
<option value="Incomplete" @if (!$firstReview && isset($lastReview->com_rev_status) 
    && trim($lastReview->com_rev_status) == 'Incomplete') SELECTED @endif 
    >Incomplete (Un-Publish)</option>
<option value="Hold: Not Sure" @if (!$firstReview && isset($lastReview->com_rev_status) 
    && trim($lastReview->com_rev_status) == 'Hold: Not Sure') SELECTED @endif 
    >Not Sure (Requires More Review, On Hold)</option>
