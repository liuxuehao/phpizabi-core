<h2>Error Page Edition</h2>
<p>&nbsp;</p><p>&nbsp;</p>
<form method="post">
<table width="100%" border="0" cellspacing="3" cellpadding="0">
  <tr>
    <td><strong>Editing error page for {error.pageName} </strong></td>
    <td align="right">
	<zone error writeLock>
    <p style="color:red"><strong>This error page is write protected. You won't be able to save your changes.</strong></p>
    </zone error writeLock>
	</td>
  </tr>
  <tr>
    <td colspan="2"><textarea name="body" rows="30" class="fullwidth">{error.pageContent}</textarea></td>
  </tr>
  <tr>
    <td height="30" colspan="2" bgcolor="#CCCCCC" style="padding-left:8px;"><input type="submit" name="Submit" value="Save Changes"></td>
  </tr>
</table>
</form>