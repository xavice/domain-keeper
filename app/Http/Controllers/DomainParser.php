<?php

namespace App\Http\Controllers;

class DomainParser extends Controller
{
	public function index()
	{
		$all_domains_url = 'https://sk-nic.sk/subory/domains.txt';
		$file_name       = 'domains.txt';

		// $file_content = file_get_contents($all_domains_url);
		// file_put_contents($file_name, $file_content);

		$handle = fopen($file_name, "r");
		$i          = 0;
		$first_line = false;
		$query      = '--';

		if ($handle) {
			while (($line = fgets($handle)) !== false) {
				$i++;
				if ($i > 15) {
					break;
				}
				if (substr($line, 0, strlen($query)) === $query) {
					continue;
				}
                // get column names
				if (!$first_line) {
					$column_names = explode(';', $line);
					$first_line   = true;

					echo '<pre oncontextmenu="javascript:this.remove(); return false;" class="print_r_2" style="position:fixed;z-index:2147483647;top:10px;right:10px;max-width:90%;max-height:90%;overflow:auto;display:block;padding:10px;margin:0px;font:normal 14px/15px \'Consolas\';text-align:left;word-break:break-all;word-wrap:break-word;color:#333;background-color: rgba(239, 232, 232, 0.98);border:1px solid #ccc;border-radius:3px;">'.
					print_r($column_names, true).'</pre>
					<script> var prints = document.getElementsByClassName("print_r_2"); var body = document.getElementsByTagName("body")[0]; [...prints].forEach(function(element) { body.appendChild(element); });</script>';
				} else {
					$line_arr              = explode(';', $line);
					$expiration_date       = strtotime($line_arr[8]);
					$mysql_expiration_date = date('Y-m-d H:i:s', $expiration_date);
					// $stmt                  = $db->prepare('
					// 	INSERT INTO domains (name, expiration_date)
					// 	VALUES(?, ?)
					// 	ON DUPLICATE KEY UPDATE expiration_date = VALUES(expiration_date)
					// 	');
					// $values[] = $line_arr[0];
					// $values[] = $mysql_expiration_date;

					// $stmt->execute($values);
					
					$values = [];
				}
			}
			fclose($handle);
		} else {
			echo 'Error opening a file.';
		}

        // $sld = 'autobaterie24.sk';
        // $domain = new Whois($sld);
        // $whois_answer = $domain->info();

        // echo $domain->htmlInfo();

        // if ($domain->isAvailable()) {
        //     echo "Domain is available\n";
        // } else {
        //     echo "Domain is registered\n";
        // }
	}
}
