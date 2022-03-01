<?php
	include "base64Img.php";
?>
<!DOCTYPE html>
<html>
	<body>
		<style>
            .tablekita {
              border-collapse: collapse;
              border: 2px solid red;
              color: red;
              font-family: Arial;
              z-index: -1;
            }

            tr.border_bottom td {
              border-bottom: 1pt solid red;
            }

            .center {
              text-align: center;
            }

            .right {
              text-align: right;
              font-size: 10px;
            }

            td.status-eng {
              font-size: 16px; 
              height: 30px; 
            }

            td.status-ind {
              font-size: 10px; 
              height: 30px; 
            }

            td.status-eng-long {
              font-size: 10px; 
              height: 30px;
            }   

            td.status-ind-long {
              font-size: 6px; 
              height: 30px; 
            }    

      </style>
        <table class="tablekita" width="140px">
          <tbody>
            <tr class="center">
              <td>
                <img id="target" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAA+CAYAAABZcVnrAAABiUlEQVRoge2WwQ7CMAiGGx/BN1g8LXspE5/aB3CevXmbR02F8pfCypaRmDhLy8cPdKZkZPMwLvMwLtxzd/sFCgeX0hcqJFxKGwLMv4exTQ0J9XzYLiz0JOdw4SApmAOwxjjAMJAHYKtxU9wFkHutSYCrQFMBEED1v52akkg+knK5L8L154gERxOVFEPOgxREFK4FRM8TAdEWqO0/sxKjV0dLksXyo9cCpQA3CNJEszAIIJe5pBbXbzXqS7+RVnKSVCopiShrYkhgqWfVAVsg8zWT2BrpkeFoTdIEsLW3xL3aq4FSMF9vSVIFiA4FqqYZoDShzPq9thpqwNc0nVH40roLIKcaCsgpDANKQeZhXJaUTlSJUMDcV9oPB+KgtIBNMcMDaiG1gKqkNMHW2qPOzAoQgtME9PaHD/D+7AOwFxwE2RsubKlhoB6QTXDekCZwXpCmcJsALEFa+bsAeuw5LJRxZSuV03VIUBANuBsgtRZOQQLwTUGvDvgYxhvl+7xMV07V0D3InUPZB2XCWXOgXMzAAAAAAElFTkSuQmCC" width="32" />
              </td>
            </tr>
            <tr class="center border_bottom">
              <td style="font-size: 9px"><b>BIRO KLASIFIKASI INDONESIA</b></td>
            </tr>
            <tr><td><br></td></tr>
            <tr class="center">
              <td class="status-eng">
                <b><br>APPROVED</b>
              </td>
            </tr>
            <tr class="center border_bottom">
              <td class="status-ind">
                            <b><i>DISETUJUI</i></b>
                          </td>
            </tr>
            <tr>
              <td style="font-size:9px; text-align: left;">
                <b>Number: 000000000</b>
              </td>
            </tr>
            <tr>
              <td style="font-size:7px; text-align: left;">
                <i>Nomor:</i>
              </td>
            </tr>
            <tr>
                <td class="center">
                    <img id="cert" src=<?php echo $sign150Base64;?> width="85"/>
                </td>
            </tr>
            <tr><td><br></td></tr>
            <tr class="right">
              <td>
                Jakarta,<u>23/02/2020</u>
              </td>
            </tr>
          </tbody>
        </table>
	</body>
</html>