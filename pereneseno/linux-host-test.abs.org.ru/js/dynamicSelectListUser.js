(function($){
	jQuery.fn.dynamicSelectListUser = function(){

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
					$('#userList').empty();

					if(mask.length>=3)
					{
						$.ajax({
							url: 'system/api.php?dynamicSelect&class=' + _classData + '&properties=' + _properties + '&mask=' + mask,
							dataType: "json",
							type: 'POST',
							success: function (data) {
								if (data.length>=1)
								{
									$('#UserColl').css("display", "none");
									$('#listColl').css("display", "none");
									$('.tds-list').empty();
									
									$.each(data,function(i,item){
										var tr = '<tr><td>' + item.id + '</td><td>' + item.surname + '</td><td>' + item.name + '</td><td>' + item.middlename + '</td><td>' + item.profession + '</td><td>' + item.subunit.name + '</td><td>' + item.group.name + '</td><td>' + item.login + '</td><td>' + item.password + '</td><td><button type="button" class="btn btn-outline-secondary castom-menu-button editObjBtn" data-toggle="tooltip" data-placement="top" title="" data-original-title="Изменить пользователя" data-obj="user" data-id="' + item.id + '"><i class="material-icons">edit</i></button><button type="button" class="btn btn-outline-secondary castom-menu-button userCardBtn" data-id="' + item.id + '" data-toggle="tooltip" data-placement="top" title="" data-original-title="Карточка пользователя"><i class="material-icons">vertical_split</i></button><button type="button" class="btn btn-outline-secondary castom-menu-button deleteElementBtn" data-id="' + item.id + '" data-obj="user" data-toggle="tooltip" data-placement="top" title="" data-original-title="Удалить пользователя"><i class="material-icons">delete_forever</i></button></td><tr>';

										
										console.log(item);
										$('.tds-list').append(tr);
									});
									$("#UserDSList").css("display", "block");
								}
								else
								{
									
									$('#listPag').css("display", "block");
									$('#listColl').css("display", "block");
									$("#UserDSList").css("display", "none");

								}
							}
						});			
					}
					else
					{
						$('#listPag').css("display", "block");
						$('#listColl').css("display", "block");
						$("#UserDSList").css("display", "none");
					};
				})
			});
		};

	}})(jQuery);
