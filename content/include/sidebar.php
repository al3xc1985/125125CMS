<aside>
	<div class="sidepanel">
		<div class="sidetitle">
			<center>Tools</center>
        </div>
		<div class="sidecontent">
			<ul>
				<?php
				if(!isset($_SESSION['username'])){
	        		echo '<li><a href="?p=download">Downloads</a></li>';
	            	echo '<li><a href="?p=armory">Armory</a></li>';
				}
				else{
					echo '<li><a href="?p=download">Downloads</a></li>';
	            	echo '<li><a href="?p=armory">Armory</a></li>';
					echo '<li><a href="?p=vote">Vote</a></li>';
	            	echo '<li><a href="?p=donate">Donate</a></li>';
					echo '<li><a href="?p=recruit">Recruit</a></li>';
					echo '<li><a href="?p=ucp">User Panel</a></li>';
					echo '<li><a href="?p=logout">Logout</a></li>';
					echo '<li><a href="?p=store">Store</a></li>';
				}
				?>
			</ul>
		</div>
        <div class="sidetitle">
			<?php
			if( !isset($_SESSION['username'])){
	        	//if the user is not allowed, display a message and a link to go back to login page
				echo '<center>Login Form</center>';
			}
			else{
				echo '<center>User Info</center>';
			}
			?>
        </div>
		<div class="sidecontent">
			<center>
				<?php
				if( !isset($_SESSION['username'])){ ?>
				 <form action="" method="POST" autocomplete="off">
					<input style="display:none">
					<input type="password" style="display:none">
					<input type="text" id="user" name="username" placeholder="Username" required /><br />
					<input type="password" id="pass" name="password" placeholder="Password" required /><br />
					<input type="submit" id="submit" value="Login !" />
				</form>
				<?php 
				include "content/include/login.php";
				}
				else{ 
					echo "<font color='#3a3225'>Welcome,</font> <b>" . $_SESSION['username'] . "</b>" 
					?>
					<div class="userinfodiv">
						<?php
						$mysqli -> select_db($acc_db);
												 
						$result = $mysqli -> query("SELECT vp, dp FROM account WHERE username = '" . addslashes($_SESSION['username']) . "'");
						$result2 = $mysqli -> query("SELECT gmlevel FROM account_access WHERE id =(SELECT id FROM account WHERE username = '" . addslashes($_SESSION['username']) . "');");
						
						echo "<table border='1' class='userinfo'>
						<tr>
						<th class='userinfo-th' style='text-align:center;' colspan='2'>Hellguard Realm</th>
						</tr>";
						
						while($row = $result -> fetch_array(MYSQLI_ASSOC)) {
							echo "<tr>";
							echo "<th class='userinfo-th'>Vote Points:</th>";
							echo "<td class='userinfo-td'>" . $row['vp'] . "</td>";
						  	echo "</tr>";
						 
						  	echo "<tr>";
						  	echo "<th class='userinfo-th'>Donor Points:</th>";
						  	echo "<td class='userinfo-td'>" . $row['dp'] . "</td>";
						  	echo "</tr>";
						 }
						 
						while($row = $result2 -> fetch_array(MYSQLI_ASSOC)) {
							$gmlevel = $row['gmlevel'];
							echo "<tr>";
							echo "<th class='userinfo-th'>Account Rank</th>";
								switch ($gmlevel) {
								case "10":
									echo "<td class='userinfo-td' style='color:#640000;'>Owner</td>";
									break;
								case "9":
									echo "<td class='userinfo-td' style='color:#136400;'>Co-Owner</td>";
									break;
								case "8":
									echo "<td class='userinfo-td' style='color:#ff0000;'>Head Admin</td>";
									break;
								case "7":
									echo "<td class='userinfo-td' style='color:#ffcc00;'>Admin</td>";
									break;
								case "6":
									echo "<td class='userinfo-td' style='color:#ffffff;'>Dev</td>";
									break;
								case "5":
									echo "<td class='userinfo-td' style='color:#0084ff;'>Head GM</td>";
									break;
								case "4":
									echo "<td class='userinfo-td' style='color:#00fffc;'>GM</td>";
									break;
								case "3":
									echo "<td class='userinfo-td' style='color:#376261;'>Trial GM</td>";
									break;
								case "2":
									echo "<td class='userinfo-td' style='color:#a1a1a1;'>Moderator</td>";
									break;
								case "1":
									echo "<td class='userinfo-td' style='color:#ff8400;'>VIP</td>";
									break;
								default:
									echo "<td class='userinfo-td' style='color:#b5b5b5;'>Player</td>";
								}
							echo "</tr>";
						}
							
						$row = $result2 -> fetch_array(MYSQLI_ASSOC); 
						$num_results = $result2 -> num_rows; 
						if ($num_results > 0){}
						else{ 
							echo "<th class='userinfo-th'>Account Rank</th>";
							echo "<td class='userinfo-td' style='color:#b5b5b5;'>Player</td>";
							echo "</tr>";
						}
						 
						echo "</table>";
						?>
					</div>
				<?php } ?>
			</center>
        </div>
		<div class="sidetitle">
			<center>Online Players</center>
		</div>
		<div class="sidecontent">
			<div class="userinfodiv" id="scrolling">
				<table class="userinfo" border="1">
					<tr>
					<?php
					$mysqli -> select_db($char_db);
		
					$result = $mysqli -> query("SELECT * FROM characters WHERE online > 0");
					$num_rows = $result -> num_rows;
		
					echo "<th class='userinfo-th'>Players Online\n</th>
					<td class='userinfo-td'>$num_rows</td>";
					?>
					</tr>
						<th class="userinfo-th">Level</th>
						<th class="userinfo-th">Name</th>
					</tr>
					<?php
					$result = $mysqli -> query("SELECT guid, name, level FROM characters WHERE online > 0");
					
					while($row = mysqli_fetch_array($result)) {
						echo "<tr>";
						echo "<td class='userinfo-td'>" . $row['level'] . "</td>";
						echo "<td class='userinfo-td'>" . $row['name'] . "</td>";
						echo "</tr>";
					}
					?>
				</table>
			</div>
		</div>
		<div class="sidetitle">
			<center>Server Info</center>
		</div>
		<div class="sidecontent">
			<div class="userinfodiv" id="scrolling">
				<center><h4 style="color:#3a3225; margin:0;">Online/Offline Status</h4></center>
				<?php
				$mysqli -> select_db($acc_db);
				
				$result = $mysqli -> query("SELECT * FROM realmlist WHERE id='1'");
				
				echo '<center>
				<div class="ServerStatus">
				<table>';
				
				while($row = $result -> fetch_array(MYSQLI_ASSOC)) {
					$Online = $row['flag'];
					echo "<tr>";
					echo "<th style='padding-right:25px; color:#3a3225;'>Status:</th>";
					switch ($Online) {
						case "0":
							echo "<td style='padding-left:25px; color:#72ff00;'>Online</td>";
							break;
						case "1":
							echo "<td style='padding-left:25px; color:#ff0000;'>Offline</td>";
							break;
					}
				}
				echo "</tr>";
				echo "</table>";
				?>
			</div>
		</div>
	</div>
</aside>