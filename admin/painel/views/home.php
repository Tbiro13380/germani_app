<script type="text/javascript">

	Highcharts.setOptions({
    	global: {
        	useUTC: false
    	}
	});

    var chart; // global
    function requestData() {
        $.ajax({
                url: 'model/home/jsonVisitors', 
                success: function(point) {
                    var series = chart.series[0],
                        shift = series.data.length > 20; // shift if the series is longer than 20
        
                    // add the point
                    chart.series[0].addPoint(eval(point), true, shift);
                    
                    // call it again after one second
                    setTimeout(requestData, 1000);  
                },
                cache: false
            });
        }
            
        /*$(document).ready(function() {
            chart = new Highcharts.Chart({
                chart: {
                    renderTo: 'online',
                    defaultSeriesType: 'spline',
                    events: {
                        load: requestData
                    }
                },
                title: {
                    text: 'Visitantes Online'
                },
                xAxis: {
                    type: 'datetime',
                    tickPixelInterval: 150,
                    maxZoom: 20 * 1000,
                },
                yAxis: {
                    minPadding: 0.2,
                    maxPadding: 0.2,
                    title: {
                        text: 'Total Online',
                        margin: 80
                    }
                },
                series: [{
                    name: 'Visitantes Online',
                    data: []
                }]
            });     
        });*/


        <?php $sql = "SELECT * FROM sys_visitors WHERE 1=1 AND data LIKE '%".date("Y-m")."%'" ?>

        $(function () {
		   $('#visitas_mes').highcharts({

				title: {
					text: 'Relatorio de visitas dos dias de <?php echo nomeMes(date("m"))."/".date("Y"); ?>',
					x: -20 //center
				},
				subtitle: {
					text: '',
					x: -20
				},
				xAxis: {
					categories: [ <?php 
						foreach($conn->query($sql)->fetchAll(PDO::FETCH_OBJ) as $ln){
		                	echo '"Dia '.date('d', strtotime($ln->data)).'",';
		                } ?>
					]
				},
				yAxis: {
					title: {
						text: 'Visitas'
					},
					plotLines: [{
						value: 0,
						width: 1,
						color: '#808080'
					}]
				},
				tooltip: {
					valueSuffix: ''
				},
				legend: {
					layout: 'vertical',
					align: 'right',
					verticalAlign: 'middle',
					borderWidth: 0
				},
				series: [{
					name: 'Visitas',
					data: [ <?php 
						foreach($conn->query($sql)->fetchAll(PDO::FETCH_OBJ) as $ln2){
		                	echo $ln2->uniques.',';
		                } ?>
					]
				}],
				responsive: {
                    rules: [{
                        condition: {
                            maxWidth: 500 // Largura máxima em pixels
                        },
                        chartOptions: {
                            // Opções de configuração do gráfico para largura menor que 500 pixels
                            chart: {
                                width: '100%' // Define a largura do gráfico como 100%
                            }
                        }
                    }]
                }
			});
		});
		
		$(function () {
    	
    	// Radialize the colors
		Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function(color) {
		    return {
		        radialGradient: { cx: 0.5, cy: 0.3, r: 0.7 },
		        stops: [
		            [0, color],
		            [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
		        ]
		    };
		});
		
    });
</script>

<?php
    //$crescimento = ($total_clientes - $total_clientes_mes_passado) / $total_clientes_mes_passado * 100;

    $totalClientes = $conn->query("SELECT count(*) AS total FROM clientes")->fetch(PDO::FETCH_OBJ)->total;
    
?>

<p class="fs-2 mb-0">Home</p>

<div class="alert alert-info mt-3" role="alert"> <p style="font-size: 14px;" class="mb-0">
  Precisa de ajuda? Acesse o help <a data-bs-toggle="modal" data-bs-target="#modalHelp" href="#modalHelp" class="alert-link">Clicando Aqui</a>
  <?php if(@$_SESSION["emailAdmin"] == "guilherme.tiburcio.ferreira@gmail.com"): ?><a href="javascript:;" class="pull-right editar-help">Editar help</a></p><?php endif; ?>
</div>

<div id="visitas_mes" class="d-md-block d-none" style="margin: 0 auto"></div>

<!--<a class="pull-right" href="view/visitors-report">Relat璐竢io Completo</a>-->

<form name="formTexto" class="formTexto" method="post" action="#">
    <div class="result"></div>
    <textarea name="help" id="editText" style="cursor: text!important;"><?php echo sistema($conn, "help"); ?></textarea>
    <br />
    <input type="submit" value="Salvar" class="btn btn-primary" />
    <span>Ou Ctrl+S</span>
</form>

<!-- Texto Help -->
<div id="modalHelp" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalHelp" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
				<h4 class="modal-title">Recomendações para administração do site</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <h1 class="text-danger text-center">IMPORTANTE</h1>
                <p class="text-center">Leia atentamente os tópicos abaixo antes de alimentar o site e periodicamente.</p>
                <br />
                <div class="text-help-exib"><?php echo sistema($conn, "help"); ?></div>
                <div class="modal-footer">
                    <button  data-bs-dismiss="modal" class="btn btn-primary">Fechar</button>
                </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Editar Help -->
<script>
    
    $(document).ready(function(){
        $(".formTexto").hide();
        $(".editar-help").click(function() {
            	$(".formTexto").slideToggle("slow", function() {
            });
        });
    });

    $(function(){
         $('#editText').editable({
             inlineMode: false, 
             language: 'pt_br', 
             inverseSkin: true,
             minHeight: 300,
             borderColor: '#000',
             buttons: ['align', 'bold', 'italic', 'underline', 'undo', 'redo', 'insertImage', 'insertVideo', 'createLink']
         })
     });

    $(window).bind('keydown', function(event) {
        if(event.ctrlKey || event.metaKey)
        {
            switch (String.fromCharCode(event.which).toLowerCase()) {
            case 's':
                event.preventDefault();

                $(".formTexto input[type=submit]").val("Carregando...");
                $.ajax({ 
                    type: "POST",
                    url: "models/postHelp.php",
                    data: jQuery("form").serialize(),
                    success: function(msg)
                    {
                        $(".formTexto .result").hide().html(msg).fadeIn('slow');
                        $(".formTexto input[type=submit]").val("Salvar");
                    }
                });

                break;
            }
        }
    })
    
    $(document).ready(function(){
        $(".formTexto input[type=submit]").click(function(evento){
            evento.preventDefault();
            $(this).val("Carregando...");
            $.ajax({ 
                type: "POST",
                url: "models/postHelp.php",
                data: jQuery("form").serialize(),
                success: function(msg)
                {
                    $(".formTexto .result").hide().html(msg).fadeIn('slow');
                    $(".formTexto input[type=submit]").val("Salvar");
                }
            });
        });
    });

</script>