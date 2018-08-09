@extends('layouts.default')

@section('content')

    <section class="users component">

        <div class="row">

            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Permissions for Role {{ $role->display_name }}
                    </h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table align="center" border="0" cellpadding="4" cellspacing="0" class="tborder" width="90%">
                            <colgroup span="2">
                                <col style="width: 70%">
                                <col style="width: 30%">
                            </colgroup>
                            <tbody>
                            <tr>
                                <td align="center" class="tcat" colspan="2">
                                    <div style="float:right">
                                        &nbsp;
                                    </div><b>Global Permissions</b>
                                </td>
                            </tr>
                            <tr valign="top">
                                <td class="alt1">Can Access Website</td>
                                <td class="alt1">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tbody>
                                        <tr valign="top">
                                            <td>
                                                <div class="smallfont" id="ctrl_usergroup[wolpermissions][canwhosonline]" style="white-space:nowrap">
                                                    <label for="rb_1_usergroup[wolpermissions][canwhosonline]_45"><input checked="checked" id="rb_1_usergroup[wolpermissions][canwhosonline]_45" name="usergroup[wolpermissions][canwhosonline]" tabindex="1" type="radio" value="1">Yes</label> <label for="rb_0_usergroup[wolpermissions][canwhosonline]_45"><input id="rb_0_usergroup[wolpermissions][canwhosonline]_45" name="usergroup[wolpermissions][canwhosonline]" tabindex="1" type="radio" value="0">No</label>
                                                </div>
                                            </td>
                                            <td align="right" style="padding-left:4px">
                                                &nbsp;
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr valign="top">
                                <td class="alt2">Can Access Video Center</td>
                                <td class="alt2">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tbody>
                                        <tr valign="top">
                                            <td>
                                                <div class="smallfont" id="ctrl_usergroup[wolpermissions][canwhosonlineip]" style="white-space:nowrap">
                                                    <label for="rb_1_usergroup[wolpermissions][canwhosonlineip]_46"><input id="rb_1_usergroup[wolpermissions][canwhosonlineip]_46" name="usergroup[wolpermissions][canwhosonlineip]" tabindex="1" type="radio" value="1">Yes</label> <label for="rb_0_usergroup[wolpermissions][canwhosonlineip]_46"><input checked="checked" id="rb_0_usergroup[wolpermissions][canwhosonlineip]_46" name="usergroup[wolpermissions][canwhosonlineip]" tabindex="1" type="radio" value="0">No</label>
                                                </div>
                                            </td>
                                            <td align="right" style="padding-left:4px">
                                                &nbsp;
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr valign="top">
                                <td class="alt1">Can Access Progress Bars</td>
                                <td class="alt1">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tbody>
                                        <tr valign="top">
                                            <td>
                                                <div class="smallfont" id="ctrl_usergroup[wolpermissions][canwhosonlinefull]" style="white-space:nowrap">
                                                    <label for="rb_1_usergroup[wolpermissions][canwhosonlinefull]_47"><input id="rb_1_usergroup[wolpermissions][canwhosonlinefull]_47" name="usergroup[wolpermissions][canwhosonlinefull]" tabindex="1" type="radio" value="1">Yes</label> <label for="rb_0_usergroup[wolpermissions][canwhosonlinefull]_47"><input checked="checked" id="rb_0_usergroup[wolpermissions][canwhosonlinefull]_47" name="usergroup[wolpermissions][canwhosonlinefull]" tabindex="1" type="radio" value="0">No</label>
                                                </div>
                                            </td>
                                            <td align="right" style="padding-left:4px">
                                                &nbsp;
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr valign="top">
                                <td class="alt2">Can Access Docs & Links</td>
                                <td class="alt2">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tbody>
                                        <tr valign="top">
                                            <td>
                                                <div class="smallfont" id="ctrl_usergroup[wolpermissions][canwhosonlinebad]" style="white-space:nowrap">
                                                    <label for="rb_1_usergroup[wolpermissions][canwhosonlinebad]_48"><input id="rb_1_usergroup[wolpermissions][canwhosonlinebad]_48" name="usergroup[wolpermissions][canwhosonlinebad]" tabindex="1" type="radio" value="1">Yes</label> <label for="rb_0_usergroup[wolpermissions][canwhosonlinebad]_48"><input checked="checked" id="rb_0_usergroup[wolpermissions][canwhosonlinebad]_48" name="usergroup[wolpermissions][canwhosonlinebad]" tabindex="1" type="radio" value="0">No</label>
                                                </div>
                                            </td>
                                            <td align="right" style="padding-left:4px">
                                                &nbsp;
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr valign="top">
                                <td class="alt1">Can Access Users</td>
                                <td class="alt1">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tbody>
                                        <tr valign="top">
                                            <td>
                                                <div class="smallfont" id="ctrl_usergroup[wolpermissions][canwhosonlinelocation]" style="white-space:nowrap">
                                                    <label for="rb_1_usergroup[wolpermissions][canwhosonlinelocation]_49"><input id="rb_1_usergroup[wolpermissions][canwhosonlinelocation]_49" name="usergroup[wolpermissions][canwhosonlinelocation]" tabindex="1" type="radio" value="1">Yes</label> <label for="rb_0_usergroup[wolpermissions][canwhosonlinelocation]_49"><input checked="checked" id="rb_0_usergroup[wolpermissions][canwhosonlinelocation]_49" name="usergroup[wolpermissions][canwhosonlinelocation]" tabindex="1" type="radio" value="0">No</label>
                                                </div>
                                            </td>
                                            <td align="right" style="padding-left:4px">
                                                &nbsp;
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        <!-- Video Permissions -->
                        <table align="center" border="0" cellpadding="4" cellspacing="0" class="tborder" width="90%">
                            <colgroup span="2">
                                <col style="width: 70%">
                                <col style="width: 30%">
                            </colgroup>
                            <tbody>
                            <tr>
                                <td align="center" class="tcat" colspan="2">
                                    <div style="float:right">
                                        &nbsp;
                                    </div><b>Video Center Permissions</b>
                                </td>
                            </tr>
                            <tr valign="top">
                                <td class="alt1">Can View Videos</td>
                                <td class="alt1">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tbody>
                                        <tr valign="top">
                                            <td>
                                                <div class="smallfont" id="ctrl_usergroup[genericpermissions][canviewmembers]" style="white-space:nowrap">
                                                    <label for="rb_1_usergroup[genericpermissions][canviewmembers]_52"><input checked="checked" id="rb_1_usergroup[genericpermissions][canviewmembers]_52" name="usergroup[genericpermissions][canviewmembers]" tabindex="1" type="radio" value="1">Yes</label> <label for="rb_0_usergroup[genericpermissions][canviewmembers]_52"><input id="rb_0_usergroup[genericpermissions][canviewmembers]_52" name="usergroup[genericpermissions][canviewmembers]" tabindex="1" type="radio" value="0">No</label>
                                                </div>
                                            </td>
                                            <td align="right" style="padding-left:4px">
                                                &nbsp;
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr valign="top">
                                <td class="alt2">Can Annotate Videos</td>
                                <td class="alt2">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tbody>
                                        <tr valign="top">
                                            <td>
                                                <div class="smallfont" id="ctrl_usergroup[genericpermissions][canmodifyprofile]" style="white-space:nowrap">
                                                    <label for="rb_1_usergroup[genericpermissions][canmodifyprofile]_53"><input checked="checked" id="rb_1_usergroup[genericpermissions][canmodifyprofile]_53" name="usergroup[genericpermissions][canmodifyprofile]" tabindex="1" type="radio" value="1">Yes</label> <label for="rb_0_usergroup[genericpermissions][canmodifyprofile]_53"><input id="rb_0_usergroup[genericpermissions][canmodifyprofile]_53" name="usergroup[genericpermissions][canmodifyprofile]" tabindex="1" type="radio" value="0">No</label>
                                                </div>
                                            </td>
                                            <td align="right" style="padding-left:4px">
                                               &nbsp;
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr valign="top">
                                <td class="alt1">Can Create Columns</td>
                                <td class="alt1">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tbody>
                                        <tr valign="top">
                                            <td>
                                                <div class="smallfont" id="ctrl_usergroup[genericpermissions][caninvisible]" style="white-space:nowrap">
                                                    <label for="rb_1_usergroup[genericpermissions][caninvisible]_54"><input checked="checked" id="rb_1_usergroup[genericpermissions][caninvisible]_54" name="usergroup[genericpermissions][caninvisible]" tabindex="1" type="radio" value="1">Yes</label> <label for="rb_0_usergroup[genericpermissions][caninvisible]_54"><input id="rb_0_usergroup[genericpermissions][caninvisible]_54" name="usergroup[genericpermissions][caninvisible]" tabindex="1" type="radio" value="0">No</label>
                                                </div>
                                            </td>
                                            <td align="right" style="padding-left:4px">
                                                &nbsp;
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr valign="top">
                                <td class="alt2">Can Add Annotations to Columns</td>
                                <td class="alt2">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tbody>
                                        <tr valign="top">
                                            <td>
                                                <div class="smallfont" id="ctrl_usergroup[genericpermissions][canseehidden]" style="white-space:nowrap">
                                                    <label for="rb_1_usergroup[genericpermissions][canseehidden]_55"><input id="rb_1_usergroup[genericpermissions][canseehidden]_55" name="usergroup[genericpermissions][canseehidden]" tabindex="1" type="radio" value="1">Yes</label> <label for="rb_0_usergroup[genericpermissions][canseehidden]_55"><input checked="checked" id="rb_0_usergroup[genericpermissions][canseehidden]_55" name="usergroup[genericpermissions][canseehidden]" tabindex="1" type="radio" value="0">No</label>
                                                </div>
                                            </td>
                                            <td align="right" style="padding-left:4px">
                                                &nbsp;
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        <table cellpadding="4" cellspacing="0" border="0" align="center" width="90%" class="tborder">
                            <colgroup span="2">
                                <col style="width: 70%">
                                <col style="width: 30%">
                            </colgroup>
                            <tbody><tr>
                                <td class="tfoot" colspan="2" align="center">	<button type="submit" class="btn btn-success">
                                        <span class="glyphicon glyphicon-ok-sign"></span> Save
                                    </button>
                                </td>
                            </tr>
                            </tbody></table>
                    </div>
                </div>
            </div>

        </div>

    </section>
    <script type="text/javascript" src="{{ app('request')->root() }}/vendors/datatables/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="{{ app('request')->root() }}/vendors/datatables/js/dataTables.bootstrap.js"></script>
    <script type="text/javascript" src="{{ app('request')->root() }}/js//custom_js/datatables_custom.js"></script>
@endsection
