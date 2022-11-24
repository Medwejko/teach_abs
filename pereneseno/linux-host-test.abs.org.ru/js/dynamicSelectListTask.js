(function($){
	jQuery.fn.dynamicSelectListTask = function(){

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
					$('#userTask').empty();

					if(mask.length>=3)
					{
						$.ajax({
							url: 'system/api.php?dynamicSelectTask&class=' + _classData + '&properties=' + _properties + '&mask=' + mask,
							dataType: "json",
							type: 'POST',
							success: function (data) {
								if (data.length>=1)
								{
									$('#TaskColl').css("display", "none");
									$('#listColl').css("display", "none");
									$('.tds-list').empty();
									console.log(data);
									$.each(data[0],function(i,item){
										console.log(item.id);
										if (item.status == 0) 
										{
											var stat = '<span style="font-weight:bold;color:red;">Не пройден</span>';
										}
										else if (item.status == 1) 
										{
											var stat = '<span style="font-weight:bold;color:orange;">Назначен</span>';
										}
										else
										{
											var stat = '<span style="font-weight:bold;color:green;">Пройден</span>';
										};

										var tr = '<tr><td>' + item.id + '</td><td>' + item.createdate + '</td><td>' + item.test.name + '</td><td>' + item.user.surname + ' ' + item.user.name + ' ' + item.user.middlename + '</td>'
										+ '<td class="td-list">' + stat + '</td>'
										+'<td class="td-list"><button type="button" class="btn btn-outline-secondary castom-menu-button statusBtn" data-obj="'+ item.id + '" data-toggle="tooltip" data-placement="top" title="" data-original-title="Статус пользователей"><i class="material-icons">list_alt</i></button>'
										+'<button type="button" class="btn btn-outline-secondary castom-menu-button bitrixBtn" data-id="'+ item.id +'" data-obj="task" data-toggle="tooltip" data-placement="top" title="" data-original-title="Отправить задачи в Битрикс"><i class="material-icons">notification_important</i></button>'
										+'<button type="button" class="btn btn-outline-secondary castom-menu-button resultTaskBtn" data-id="'+ item.id +'" data-test="'+ item.test.id +'" data-toggle="tooltip" data-placement="top" title="" data-original-title="Вывести результаты"><i class="material-icons">print</i></button>'
										+'<button type="button" class="btn btn-outline-secondary editObjBtn castom-menu-button" data-toggle="tooltip" data-placement="top" title="" data-original-title="Изменить задачу" data-obj="task" data-id="'+ item.id +'"><i class="material-icons">edit</i></button>'
										+'<button type="button" class="btn btn-outline-secondary deleteElementBtn castom-menu-button" data-id="'+ item.id +'" data-obj="task" data-toggle="tooltip" data-placement="top" title="" data-original-title="Удалить задачу"><i class="material-icons">delete_forever</i></button>'
										+'</td><tr>';

										
										
										$('.tds-list').append(tr);
									});
									$("#TaskDSList").css("display", "block");
								}
								else
								{
									
									$('#listPag').css("display", "block");
									$('#listColl').css("display", "block");
									$("#TaskDSList").css("display", "none");

								}
							}
						});			
					}
					else
					{
						$('#listPag').css("display", "block");
						$('#listColl').css("display", "block");
						$("#TaskDSList").css("display", "none");
					};
				})
			});
		};

	}})(jQuery);
