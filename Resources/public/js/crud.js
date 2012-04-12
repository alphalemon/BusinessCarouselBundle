/*
 * This file is part of the BusinessCarouselBundle and it is distributed
 * under the GPL LICENSE Version 2.0. To use this application you must leave
 * intact this copyright notice.
 *
 * Copyright (c) AlphaLemon <webmaster@alphalemon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * For extra documentation and help please visit http://www.alphalemon.com
 * 
 * @license    GPL LICENSE Version 2.0
 * 
 */

(function($){
    $.fn.AddCarouselItem = function(blockId)
    {
        this.each(function() 
        {
            $(this).click(function()
            {
                showCarouselForm(blockId);
                
                return false;
            });
        });
    };
    
    $.fn.EditCarouselItem = function(blockId)
    {
        this.each(function() 
        {
            $(this).click(function()
            {
                showCarouselForm(blockId, $(this).attr('rel'));
                
                return false;
            });
        });
    };
    
    $.fn.DeleteCarouselItem = function(blockId)
    {
        this.each(function() 
        {
            $(this).click(function()
            {
                deleteCarouselItem(blockId, $(this).attr('rel'));
                
                return false;
            });
        });
    };
    
    $.fn.ListCarouselItems = function()
    {    
        this.each(function() 
        {
            $(this).click(function()
            {
                $.ajax({
                    type: 'GET',
                    url: frontController + 'backend/' + $('#al_available_languages').val() + '/al_listItems',
                    data: {'id' : $('#al_carousel_item_block_id').val()},
                    beforeSend: function()
                    {
                        $('body').AddAjaxLoader();
                    },
                    success: function(html)
                    {
                        $('#al_editor_dialog').html(html);
                        $('#al_editor_dialog').dialog('open');
                    },
                    error: function(err)
                    {
                        $('#al_editor_dialog').html(err.responseText);
                        $('#al_editor_dialog').dialog('open');
                    },
                    complete: function()
                    {
                        $('body').RemoveAjaxLoader();
                    }
                });
                
                return false;
            });
        });
    }
})($);

function showCarouselForm(blockId, id)
{
    if(id == null) id = 0;
    
    $.ajax({
      type: 'GET',
      url: frontController + 'backend/' + $('#al_available_languages').val() + '/al_showItemForm',
      data: {'id' : id, 'block_id' : blockId },
      beforeSend: function()
      {
        $('body').AddAjaxLoader();
      },
      success: function(response)
      {
        updateCarouselFromJSon(response);
      },
      error: function(err)
      {
        $('#al_error').html(err.responseText);
      },
      complete: function()
      {
        $('body').RemoveAjaxLoader();
      }
    });
    
    return false;
}

function deleteCarouselItem(blockId, id)
{
    if(confirm("Are you sure you want to remove the selected item?"))
    {
        $.ajax({
            type: 'POST',
            url: frontController + 'backend/' + $('#al_available_languages').val() + '/al_deleteItem',
            data: {'id' : id, 
                   'blockId' : blockId },
            beforeSend: function()
            {
                $('body').AddAjaxLoader();
            },
            success: function(response)
            {
                updateCarouselFromJSon(response);
            },
            error: function(err)
            {
                $('#al_error').html(err.responseText);
            },
            complete: function()
            {
                $('body').RemoveAjaxLoader();
            }
            });
    }
}

function updateCarouselFromJSon(response)
{
    $(response).each(function(key, item)
    {
        switch(item.key)
        {
            case "editor":
                $('#al_editor_dialog').html(item.value);
                break;
            case "content": 
                $('#block_' + item.id).html(item.value);
                break;
        }
    });
}