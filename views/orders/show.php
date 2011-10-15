<?php
// This is page show order details
// available vars:
// $template->errors if user validation fails
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Create User</title>
        <link href="style.css" rel="stylesheet" type="text/css" />
    </head>

    <body bgcolor="#ffffff">
        <table align="center" width="80%" border="0" bgcolor="#ffffff">
            <tr><td width="1%" align="center" valign="top" class="logo">
                    <br/><br/>DiGiCell Presents<br/><img src="/Test/views/products/processors/digimall-logo.gif" /></td>
                <td  valign="top">

                    <table width="99%" border="0">
                        <tr>
                            <td width="100%" align="right" valign="top" class="menulink"> hardware&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;software&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	  specials&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	notebooks</td>
                        </tr><tr><td>&nbsp;</td></tr>
                        <tr>
                            <td valign="top" Align ="center"> 

                                <table border="0" width="100%">
                                       <tr><td colspan =" 2" align="center">

                                       <table border="0" width="100%"><tr><td width="90%" class="menulink" align="center">
 
                                            </td></tr></table>
                                    <table border="0" width="100%" cellpadding="3" >
                                           <tr><td >
                                                <table border="0" align="center" bgcolor="#99ccff">
													<tr><td> 

		<h2>List of Items</h2>
		<p><a href="/Test/session/destroy">Log out</a><p>
		<?php if (isset($template->orders)): ?>
		<h2>This is the show page for the model "<?php echo $template->orders[0]['model_name']; ?>"</h2>
			<form method='POST' action='confirm'>
				<p>Processor:</p>
				<input type='radio' name='processor' value='<?php echo $template->orders[0]['proc_id']; ?>'>&nbsp&nbsp<?php echo $template->orders[0]['proc_name']; ?>
					<ul>
						<li>Model: <?php echo $template->orders[0]['proc_model']; ?></li>
						<li>Speed: <?php echo $template->orders[0]['proc_speed']; ?></li>
					</ul>
				</input>
				<input type='radio' name='processor' value='<?php echo $template->orders[1][0]['proc_id']; ?>'>&nbsp&nbsp<?php echo $template->orders[1][0]['proc_name']; ?>
					<ul>
						<li>Model: <?php echo $template->orders[1][0]['proc_model']; ?></li>
						<li>Speed: <?php echo $template->orders[1][0]['proc_speed']; ?></li>
					</ul>
				</input>	
				<p>Motherboard:</p>
				<input type='radio' name='motherboard' value='<?php echo $template->orders[0]['mb_id']; ?>' selected>&nbsp&nbsp<?php echo $template->orders[0]['mb_model']; ?>
					<ul>
						<li>Socket: <?php echo $template->orders[0]['mb_socket']; ?></li>
						<li>Chipset: <?php echo $template->orders[0]['mb_chipset']; ?></li>
						<li>Built-in Graphics: <?php echo $template->orders[0]['mb_graphics']; ?></li>
						<li>RAM Slots: <?php echo $template->orders[0]['mb_ram_slot']; ?></li>
						<li>PCI Express Slots: <?php echo $template->orders[0]['mb_pcie_slot']; ?></li>
					</ul>
				</input>
				<p>RAM:</p>
				<input type='radio' name='ram' value='<?php echo $template->orders[0]['ram_id']; ?>' selected>&nbsp&nbsp<?php echo $template->orders[0]['ram_type']; ?>
					<ul>
						<li>Capacity: <?php echo $template->orders[0]['ram_capacity']; ?></li>
						<li>Speed: <?php echo $template->orders[0]['ram_speed']; ?></li>
					</ul>
				</input>
				<input type='radio' name='ram' value='<?php echo $template->orders[1][0]['ram_id']; ?>' selected>&nbsp&nbsp<?php echo $template->orders[1][0]['ram_type']; ?>
					<ul>
						<li>Capacity: <?php echo $template->orders[1][0]['ram_capacity']; ?></li>
						<li>Speed: <?php echo $template->orders[1][0]['ram_speed']; ?></li>
					</ul>
				</input>
				<p>Harddisk:</p>
				<input type='radio' name='harddisk' value='<?php echo $template->orders[0]['hdd_id']; ?>' selected>&nbsp&nbsp<?php echo $template->orders[0]['hdd_model']; ?>
					<ul>
						<li>Capacity: <?php echo $template->orders[0]['hdd_capacity']; ?></li>
						<li>Type: <?php echo $template->orders[0]['hdd_type']; ?></li>
					</ul>
				</input>
				<input type='radio' name='harddisk' value='<?php echo $template->orders[1][0]['hdd_id']; ?>' selected>&nbsp&nbsp<?php echo $template->orders[1][0]['hdd_model']; ?>
					<ul>
						<li>Capacity: <?php echo $template->orders[1][0]['hdd_capacity']; ?></li>
						<li>Type: <?php echo $template->orders[1][0]['hdd_type']; ?></li>
					</ul>
				</input>
				<p>Optical Rom:</p>
				<input type='radio' name='optical_rom' value='<?php echo $template->orders[0]['rom_id']; ?>' selected>&nbsp&nbsp<?php echo $template->orders[0]['rom_model']; ?>
					<ul>
						<li>Type: <?php echo $template->orders[0]['rom_type']; ?></li>
					</ul>
				</input>
				<p>Graphics:</p>
				<input type='radio' name='graphics' value='<?php echo $template->orders[0]['graphics_id']; ?>' selected>&nbsp&nbsp<?php echo $template->orders[0]['graphics_model']; ?>
					<ul>
						<li>Capacity: <?php echo $template->orders[0]['graphics_capacity']; ?></li>
						<li>RAM Type: <?php echo $template->orders[0]['graphics_ram_type']; ?></li>
						<li>Bit: <?php echo $template->orders[0]['graphics_bit']; ?></li>
					</ul>
				</input>
				<p>Monitor:</p>
				<input type='radio' name='monitor' value='<?php echo $template->orders[0]['disp_id']; ?>' selected>&nbsp&nbsp<?php echo $template->orders[0]['disp_type']; ?>
					<ul>
						<li>Size: <?php echo $template->orders[0]['disp_size']; ?></li>
						<li>Refresh Rate: <?php echo $template->orders[0]['disp_refresh']; ?></li>
						<li>Contrast Ratio: <?php echo $template->orders[0]['disp_contrast']; ?></li>
						<li>Max Resolution: <?php echo $template->orders[0]['disp_resolution']; ?></li>
					</ul>
				</input>
				
				<input type='submit' name='confirm' value='Confirm' />
		<?php else: ?>
    	<h2>The processor with id "<?php echo $template->id; ?>" does not exist</h2>
		<?php endif; ?>
</td></tr>
                                                </table>
                                            </td></tr>
									</table>
                            </td>
                        </tr>
                    </table>
                </td><td valign="top" width="18%"><br/><br/>
                    <table bgcolor="ffffff" border =0 cellpadding="3">
                        <tr><td class="menulink" align="right">
                                Search</td></tr>
                        <tr>
                            <td align="center" bgcolor="#99ccff" class="inbox">
                                <input type="text" name="search" />
                                <input type="submit" value="Search"/> 
                            </td>
                        </tr><tr><td>&nbsp;</td></tr>
                        <tr><td class="menulink" align="right">Login</td></tr>
                        <tr><td align="center" bgcolor="#99ccff">

                                <table><tr><td class="inbox">
                                            Username<br/>
                                            <input type="text" name="username"  /><br/>
                                            Password<br/>
                                            <input type="text" name="password" /><br/>
                                            <p align="center"><input type="submit" value="Login"/></p> 
                                        </td></tr></table>
                            </td></tr><tr><td>&nbsp;</td></tr>
                        <tr><td class="menulink" align="right">Products</td></tr>
                        <tr><td bgcolor="#99ccff" class="inbox">
                                Power Supply<br/>
                                Motherboard<br/>
                                Processor  <br/>
                                Harddisk<br/>
                                DVD ROM<br/>
                                CD ROM<br/>
                                Casing<br/>
                                Keyboard<br/>
                                Mouse<br/>
                                Speakers<br/>
                                Graphic Card<br/>
                                Sound<br/>
                                Monitor<br/>


                            </td></tr>
                    </table>

            <tr><td colspan =3>
                    <table  align="center" width="90%" border ="0" cellpadding="3">
                        <tr><td class="menulink" align="right">My Account</td>
                            <td class="menulink" align="right">Customer Service</td>
                            <td class="menulink" align="right">About Us</td></tr>
                        <tr><td width="33%" valign="top" bgcolor="#99ccff" class="inbox">

                                -Register <br />
                                -Login<br />
                                -My account<br />
                                -Order status<br />
                                -Track my order<br />
                            </td>
                            <td width="33%" valign="top" bgcolor="#99ccff" class="inbox">

                                - Contact us<br />
                                - FAQ<Br />
                                - Return Policy infomation<br />
                                - feedback<br /></td>
                            <td width="34%" valign="top" bgcolor="#99ccff" class="inbox">

                                Policy & Agreement<Br />
                                Privacy<Br />
                                Payment options<Br /></td>
                        </tr>
                    </table>
                </td></tr><tr ><td colspan=3 align="center" class="footer">
                    DiGiCell � 2011 All Rights Reserved. 	
                </td>
            </tr>
        </table>
    </body>

</html>
