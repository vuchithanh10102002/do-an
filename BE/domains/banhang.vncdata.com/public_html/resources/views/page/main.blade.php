<!DOCTYPE html>
<html lang="en">
@include('page.main.header')
<body oncontextmenu="return false;" class="scroollbar-c">
<div id="jqxLoader"></div>

<div class="menu">
    @include('page.main.menu')
</div>
<div class="main">
    <div class="content" id="content"></div>
</div>

@include('page.main.notify_center')

<div id="notify">
    <div id="notify_content"></div>
</div>

@include('page.main.script')





</body>
</html>