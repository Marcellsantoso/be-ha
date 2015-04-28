<?
foreach($arr as $item){
            
            ?>
<div class="item">
    <div class="item-img"><img onload="OnImageLoad(event, 100);" src="<?=_SPPATH._PHOTOURL.$item->list_image;?>"></div>
    <div class="item-name">
        <a href="<?=_SPPATH;?>i/daftar/<?=$item->list_id;?>/<?=$item->list_name;?>.html">
            <?=$item->list_name;?>
        </a>
    </div>
    <div class="clearfix"></div>
</div>              
            <?
            
        }
        ?>
<style>
    .item{
        padding: 5px;
        margin: 5px;
    }
    .item-img{
        width: 100px;
        height: 100px;
        overflow: hidden;
        border:1px solid #dedede;
        float: left;
        border-radius: 10px;
    }
    .item-img img{
        
    }
    .item-name{
        padding-left: 10px; 
        font-size: 17px;
        float: left;
    }
</style>    
