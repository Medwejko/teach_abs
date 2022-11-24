(function($){
	jQuery.fn.dynamicSelectResult = function(){
		if (typeof window.config !== 'undefined') {
			window.config = new Object();
			confid = $('#ds-user').data("value");
			config[confid] = confid;
console.log(config);
		}
		else
		{
			confid = $('#ds-user').data("value");;
			config[confid] = confid;
		}
		if(this.length == 0)
		{
			console.log('ds obj not found');
		}
		else
		{
			$(this).each(function(index, obj){

				var id = $(obj).attr("id");

				var dsBlock = "<div style=\"display:none\" id=\"" + id + "-block\" class=\"dm-block\"><table id=\"" + id + "-table\" class=\"table table-sm ds-table table-hover\"></table></div>";
				$(obj).after(dsBlock);
				var _classData = $(obj).data('class');
				var _className = $(this).attr('name');
				var _properties = $(obj).data('properties');


				var tmp = _properties.replace(/'/g,'"');
				var _prop_arr = JSON.parse(tmp);

				$(document).on('click','.ds-result-item-' + _className,function(){
					
					var id = $(this).data('id');
					var text = $(this).html();
					config[id] = id;
					$('#ds-' + _className).val(text);
					$('#ds-' + _className).data("value",id);
					$('#ds-'+ _className + '-block').css("display", "none");

				});

				$(obj).on('keyup',function(){
					var mask = $(this).val();
					$('.dm-block').css("display", "none");
					$('#' + id + '-table').empty();

					if(mask.length>=3)
					{
						$.ajax({
							url: 'system/api.php?dynamicSelectResult&class=' + _classData + '&properties=' + _properties + '&mask=' + mask,
							dataType: "json",
							type: 'POST',
							success: function (data) {
								if (data.length>=1)
								{
									$('#' + id + '-table').append('<tbody></tbody>');
									$.each(data,function(i,item){
										var find = false;


										$.each(config,function(i,element){

											if(i == item.id)
											{

												find = true;

											};
										});
										if(!find)
										{
											var tr = '<tr><td class="ds-result-item-' + _className + '" data-class="' + _className + '" data-id="' + item.id + "\">";
											$.each(_prop_arr,function(j,prop){
												tr = tr + item[prop] + ' ';
											});
											tr = tr +'</td></tr>';
											$('#' + id + '-table').append(tr);
										};
									});
									$("#" + id + "-block").css("display", "block");
								}
								else
								{
									$('#' + id + '-table').append('<tr><td>ни чего не найдено</td></tr>');
									$("#" + id + "-block").css("display", "block");

								}
							}
						});			
					}
				})
			});
		};

	}})(jQuery);
