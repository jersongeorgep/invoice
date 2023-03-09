<?php
if(!empty($booking)) {
    foreach($booking as $row) {
        echo '<tr><td>'.$row->room_no.'</td><td>'.date('d-m-Y',strtotime($row->check_in_date)).'</td><td><strong>'.$row->salute.$row->first_name.' '.$row->last_name.'</strong><br/>Mob: <strong>'.$row->mobile.'</strong></td></tr>';
    }
} else {
echo '<tr><td colspan="3">No records found!</td></tr>';
}
?>