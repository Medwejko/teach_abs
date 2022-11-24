(function($){


	if (typeof window.config !== 'undefined') {
		window.config = new Object();
		arrCheck = {};

	}
	else
	{
		arrCheck = {};
		config = arrCheck;
	};



	jQuery.fn.dynamicMultiselect = function(){

		if(this.length == 0)
		{
			console.log('dm obj not found');
		}
		else
		{

			$(this).each(function(index, obj){

				var id = $(obj).attr("id");
				var _className = $(this).attr('noname');
				var _classData = $(obj).data('class');
				var _properties = $(obj).data('properties');
				var dmBlock = "<div style=\"display:none\" id=\"" + id + "-block\" class=\"dm-block\"><table id=\"" + id + "-table\" class=\"table table-sm dm-table table-hover\"></table></div>";
				$(obj).after(dmBlock);
				
				var collection = [];
				var arrCheck = {};
				var count = 0;

				var dm = document.getElementsByClassName('dm-'+ _className + '-edit-store');
				$(dm).each(function(index, obj){
					var id = $(obj).data('id');
					var text = $(obj).val();
					arrCheck[id] = text;
					config[id] = arrCheck;
					count++;
					$('#dm-count-'+ _className).html(count); 
					collection = [];

					for (key in arrCheck){ 

						collection.push(parseInt(key));
					}
					var col = JSON.stringify(collection);
					$('#dm-'+ _className + '-store').val(col);
				});
				
				

				var tmp = _properties.replace(/'/g,'"');
				var _prop_arr = JSON.parse(tmp);

				$(document).on('click','.dm-result-item-' + _className,function(){
					var id = $(this).data('id');
					var text = $(this).html();
					arrCheck[id] = text;
					config[id] = arrCheck;
					$('#dm-'+ _className + '-block').css("display", "none");
					$('#dm-'+ _className + '-block').val(arrCheck[id]);
					count++;
					collection = [];
console.log(arrCheck);		
					for (key in arrCheck){ 

						collection.push(parseInt(key));
					}
					var col = JSON.stringify(collection);


					$('#dm-count-'+ _className).html(count); 

					$('#dm-'+ _className + '-store').val(col);
					$('#dm-'+ _className).val('');

					console.log(col);
				});	

				$(document).on('click','#dm-'+ _className + '-btn',function(){

					$('#' + id + '-table').empty();

					if($('#dm-'+ _className + '-block').css("display") == 'none')
					{

						$('#' + id + '-table').append('<tbody></tbody>');
						$.each(arrCheck,function(i,element,){

							var tr = '<tr>'
							+ '<td class="dm-check-item-' + _className + '" data-class="' + _className + '" data-id="' + i + '">' + element + '</td>'
							+ '<td><button type="button" class="btn btn-outline-secondary removeCheck" id="' + i + '">X</td></tr>';
							$('#' + id + '-table').append(tr);
						});
						$('#' + id + "-block").css("display", "block");

					}
					else
					{
						$('#dm-'+ _className + '-block').css("display", "none");
					};

				});

				$(document).on('click','.removeCheck',function(){

					var ids = ((this).id);
					for (key in arrCheck) {
						if(key == ids)
						{

							delete arrCheck[key];
							$('#' + id + '-table').empty();
							$('#dm-'+ _className + '-block').css("display") == 'none';
							$('#' + id + '-table').append('<tbody></tbody>');
							$.each(arrCheck,function(i,element,){

								var tr = '<tr>'
								+ '<td class="dm-check-item-' + _className + '" data-class="' + _className + '" data-id="' + i + '">' + element + '</td>'
								+ '<td><button type="button" class="btn btn-outline-secondary removeCheck" id="' + i + '">X</td></tr>';
								$('#' + id + '-table').append(tr);
							});
							$('#' + id + "-block").css("display", "block");

							count = count - 1;
							collection = [];				
							console.log(arrCheck);			
							for (key in arrCheck){ 

								collection.push(parseInt(key));
							}
							var col = JSON.stringify(collection);

							$('#dm-count-'+ _className).html(count);
							$('#dm-'+ _className + '-store').val(col);
							console.log(col);
						}
						/* ... делать что-то с obj[key] ... */
					}
					for (key in config) {
						if(key == ids)
						{

							delete config[key];
						}
					}
					/*$(arrCheck).each(function(i,element){
						console.log(i);
						if(i == id)
						{
							
							delete arrCheck[i];
						}
					});*/
					
				});

				$(obj).on('keyup',function(){
					console.log(config);
					var mask = $(this).val();
					$('#' + id + '-block').css("display", "none");
					$('#' + id + '-table').empty();

					if(mask.length>=3)
					{
						$.ajax({
							url: 'system/api.php?dynamicSelect&class=' + _classData + '&properties=' + _properties + '&mask=' + mask,
							dataType: "json",
							type: 'POST',
							success: function (data) {
								if (data.length>=1)
								{

									$('#' + id + '-table').append('<tbody></tbody>');
									$.each(data,function(j,item){

										var find = false;


										$.each(config,function(i,element){

											if(i == item.id)
											{

												find = true;

											};
										});
										if(!find)
										{
											var tr = '<tr><td class="dm-result-item-' + _className + '" data-class="' + _className + '" data-id="' + item.id + '">' + item.name + ' ' + item.surname + ' ' + item.profession + '</td><><</tr>';
											$('#' + id + '-table').append(tr);
										}

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
					else
					{
						$(".dm-block").css("display", "none");
					};
				})
			});
};

}})(jQuery);
