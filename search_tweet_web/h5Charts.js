(function (){
	if(!window.h5Charts){
		window.h5Charts={};
	}
	function SerialChart(){}
	SerialChart.prototype.addTo = function(container){
		var ca = H5D.D2(container);
		if(this.type==="column"){
			var columns = this.dataProvider.length;
			var valueName = this.valueField;
			//alert(valueName);
			
			var values = [];
			for(var i = 0;i < columns;i++){
				values.push(this.dataProvider[i][valueName]);
			}
			var maxValue = Math.max.apply(Math,values);
			var  m = 1,n = 0;
			while(Math.floor(maxValue/10)!=0){
				maxValue = maxValue/10;
				m*=10;
				
				
			}
			var heighBit = Math.floor(maxValue);
			maxValue = (heighBit+1)*m;
			n = maxValue/m;
			var h = ca.height-160;
			ca.drawLine(60,60,60,ca.height-100).stroke({color:"rgb(0,0,0)",lineWidth:1});
			var eachSegY = h/n;
			//×ø±ê·Å´óÏµÊý
			var zoomK = h/maxValue;
			ca.drawLine(55,60,60,60).stroke({color:"rgb(0,0,0)"});
			ca.drawText({message:maxValue,
									textBaseLine:"middle",
					textAlign:"center ",
					font:{
						fontWeight:"normal",
						fontStyle:"normal",
						fontSize:"12",
						fontFace:"serif"
						
					},
					color:"rgb(0,0,0)",
					xPos:30,
					yPos:60,
					type:"fill"
					
					});
				
			var sY = eachSegY;
			while(h>0){
			if(h-eachSegY>0){
				ca.drawLine(55,60+sY,60,60+sY).stroke({color:"rgb(0,0,0)"});
				ca.drawText({message:maxValue-m,
									textBaseLine:"middle",
					textAlign:"center ",
					font:{
						fontWeight:"normal",
						fontStyle:"normal",
						fontSize:"12",
						fontFace:"serif"
						
					},
					color:"rgb(0,0,0)",
					xPos:30,
					yPos:60+sY,
					type:"fill"
					
					});
				}
				sY+=eachSegY;
				h-=eachSegY;
				maxValue-=m;
			}
			var w = ca.width - 160;
			
			var eachSegX = Math.floor(w/(columns+1));
			var sX = eachSegX;
			var k=0;
			while(w>=0){
			
				w-=eachSegX;
				if(w-eachSegX>=0){
				
					ca.drawLine(55+sX,ca.height-90,55+sX,ca.height-100).stroke({color:"rgb(0,0,0)"});
					ca.drawText({message:this.dataProvider[k][this.categoryField],
									textBaseLine:"middle",
					textAlign:"center ",
					font:{
						fontWeight:"normal",
						fontStyle:"normal",
						fontSize:"12",
						fontFace:"serif"
						
					},
					color:"rgb(0,0,0)",
					xPos:50+sX,
					yPos:ca.height-80,
					type:"fill"
					
					});
					ca.drawRect(55+sX-this.columnWidth/2,ca.height-100-values[k]*zoomK,this.columnWidth,values[k]*zoomK).fill({
				color:this.colors[k],
				shadow:{blur:10,color:"rgba(100,100,100,0.5)",offsetX:0,offsetY:0}
				
			});
			k++;
				}
				sX+=eachSegX;
				
			}
			ca.drawLine(60,ca.height-100,ca.width-100,ca.height-100).stroke({color:"rgb(0,0,0)"});
			
		}
	};
	window.h5Charts.SerialChart = SerialChart;
}());