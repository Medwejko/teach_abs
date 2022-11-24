(function($){
	jQuery.fn.dynamicSelectListQuestion = function(){

		if(this.length == 0)
		{
			console.log('ds obj not found');
		}
		else
		{
			$(this).each(function(index, obj){

				var id = $(obj).attr("id");
				var _classData = $(obj).data('class');
				var _className = $(this).attr('name');
				var _properties = $(obj).data('properties');


				var tmp = _properties.replace(/'/g,'"');
				var _prop_arr = JSON.parse(tmp);


				$(obj).on('keyup',function(){
					var mask = $(this).val();
					$('#DSlist').empty();

					if(mask.length>=3)
					{
						$.ajax({
							url: 'system/api.php?dynamicSelect&class=' + _classData + '&properties=' + _properties + '&mask=' + mask,
							dataType: "json",
							type: 'POST',
							success: function (data) {
								if (data.length>=1)
								{
									$('#listColl').css("display", "none");
									$('#listPag').css("display", "none");
									$('.tbds-list').empty();
									
									$.each(data,function(i,item){

										var tr = '<tr>';
										$.each(_prop_arr,function(j,prop){

											tr = tr + '<td>' + item[prop] + '</td>';
										});
										tr = tr +'<td><button type="button" class="btn btn-outline-secondary castom-menu-button editObjBtn" data-toggle="tooltip" data-placement="top" title="" data-original-title="Изменить вопрос" data-obj="question" data-id="' + item.id + '"><i class="material-icons">edit</i><button type="button" class="btn btn-outline-secondary castom-menu-button copyObjBtn" data-toggle="tooltip" data-placement="top" title="" data-original-title="Копировать вопрос" data-obj="question" data-id="' + item.id + '"><i class="material-icons">file_copy</i></button></button>&nbsp;<button type="button" class="btn btn-outline-secondary castom-menu-button deleteElementBtn" data-id="' + item.id + '" data-obj="question" data-toggle="tooltip" data-placement="top" title="" data-original-title="Удалить вопрос"><i class="material-icons">delete_forever</i></button></td><tr>';
										$('.tbds-list').append(tr);
									});
									$("#ds-list").css("display", "block");
								}
								else
								{
									
									$('#listPag').css("display", "block");
									$('#listColl').css("display", "block");
									$("#ds-list").css("display", "none");

								}
							}
						});			
					}
					else
					{
						$('#listPag').css("display", "block");
						$('#listColl').css("display", "block");
						$("#ds-list").css("display", "none");
					};
				})
			});
		};

	}})(jQuery);
