<%@ Page Language="C#" MasterPageFile="~/MasterPage.master" AutoEventWireup="true" CodeFile="MainMenu.aspx.cs" Inherits="MainMenu" 
Title="Main Menu"  %>
<asp:Content ID="Content1" ContentPlaceHolderID="ContentPlaceHolder1" Runat="Server">
<h1>Newsletter</h1>
<table cellspacing="10">
<tr valign="top">
<td width="33%">
<img src="images/buttons/newsletters.gif" align="right"/><h2><asp:HyperLink  ID="HyperLink1" runat="server" Text="&raquo; Newsletter"  NavigateUrl="~/Newsletters/default.aspx" />
    </h2>
Manage and create newsletters for sending to mailing list subscribers.

</td>
<td width="33%">
<img src="images/buttons/lists.gif" align="right"/><h2><asp:HyperLink  ID="hlListManage" runat="server" Text="&raquo; Mailing Lists"  NavigateUrl="~/Lists/default.aspx" />
    </h2>
Newsletter mailing lists contain the email addresses of the subscribers who have signed up.
</td>
<td width="33%">
<img src="images/buttons/subscribers.gif" align="right"/><h2><asp:HyperLink  ID="HyperLink5" runat="server" Text="&raquo; Subscribers"  NavigateUrl="~/Subscribers/default.aspx" />
    </h2>
Newsletter subscribers are those who have signed up to a mailing list. There is also the possible to batch add and remove from various format. 
</td>
</tr>
<tr valign="top">
<td>
<asp:Panel ID="plAdmin" runat="server">
<img src="images/buttons/users.gif" align="right"/><h2><asp:HyperLink  ID="HyperLink8" runat="server" Text="» Users & Settings"  NavigateUrl="~/Admin/Users/default.aspx" />
    </h2>
Newsletter users are those who can manage subscribers, lists and other functions. Only the administator can set up users or change the global settings.
</asp:Panel>

</td>


</tr>
</table>











</asp:Content>

