<div class="swRepForm">
{if strlen($ERRORMSG)>0}
            <div style="display:none" id="reporticoEmbeddedError">
                {$ERRORMSG}
            </div>
{literal}
            <script>
                if ( typeof($) != "undefined" )
                    $(document).ready(function()
                    {
                        showParentNoticeModal($("#reporticoEmbeddedError").html());
                    });
                else
                    if ( typeof(parent.$) != "undefined" ) 
                        parent.$(document).ready(function()
                        {   
                            parent.showNoticeModal(document.getElementById("reporticoEmbeddedError").innerHTML);
                        });
            </script>
{/literal}
            <TABLE class="swError">
                <TR>
                    <TD>{$ERRORMSG}</TD>
                </TR>
            </TABLE>
{/if}
{if strlen($STATUSMSG)>0} 
			<TABLE class="swStatus">
				<TR>
					<TD>{$STATUSMSG}</TD>
				</TR>
			</TABLE>
{/if}
</div>
