<?php
$translate = array(
					array(
							"id"=>"gen",
							"item"=>array(
											"General Data"=>"Ship Status-Place of Survey-Survey Date-Name-Previous Name-Type of Ship-Hull Material-Flag-Call Sign-Port of Registry-Contract-Builder Yard-Keel Laying-Hull Number-Launching-Completion-Previous Class-Character and Notation-Other Class-Character and Notation", 
											"Hull Data"=>"LOA-LPP-Lf-Bmld-Hmld-T-Freeboard-GT-Nett-Dead Weight-Displacement"
										),
							"type"=>"field",
							"map"=>array(
											"Ship Status"=>array("","New Building", "Existing"),
											"Material"=>array("","Steel", "Aluminium", "Wood", "FRP")
										),
							"table"=>array("General Data"=>"general", "Hull Data"=>"particular"),
							"search"=>"alltype",
							"limit"=>array(
											"General Data"=>3,
											"Hull Data"=>2
											),
							"checklist"=>false,
							"family"=>false
						),
					array(
							"id"=>"cpc",
							"item"=>"Item-Capacity",
							"type"=>"table",
							"map"=>array(
											"Item"=>array("","General cargo - bale (m3)","General cargo - grain (m3)","Cargo tank - oil (m3)","Cargo tank - other (m3)","Fuel oil tank (m3)","Lubricating oil tank (m3)","Fresh water tank (m3)","Cargo oil / ballast water tank (m3)","Ballast tank (m3)","Lubricating oil tank (m3)","Container - dry (TEU)","Container - dry (FEU)","Container - refrigerated (TEU)","Container - refrigerated (FEU)"," Vehicle (type x number)")
										),
							"table"=>"capacity",
							"search"=>"alltype",
							"limit"=>3,
							"checklist"=>false,
							"family"=>false
						),
					array(
							"id"=>"tnk",
							"item"=>"Name-Frame Start-Frame End-Protection-Coating-Cargo Heating-Common Plane",
							"type"=>"table",
							"map"=>array(
											"Protection"=>array(
																	"HC"=>"Hard Coating",
																	"SC"=>"Soft Coating",
																	"A"=>"Anode",
																	"NP"=>"No Protection"
																),
											"Coating"=>array(
																"U"=>"Upper part",
																"M"=>"Middle part",
																"L"=>"Lower part",
																"C"=>"Complete"
															)
										),
							"table"=>"tnk",
							"search"=>"project",
							"limit"=>4,
							"checklist"=>true,
							"family"=>false
						),
					array(
							"id"=>"blh",
							"item"=>"Number-Frame No-Frame Start-Frame End-Location",
							"type"=>"table",
							"map"=>array(),
							"table"=>"blh",
							"search"=>"project",
							"limit"=>4,
							"checklist"=>true,
							"family"=>false
						),
					array(
							"id"=>"dck",
							"item"=>"Deck Type-Frame No",
							"type"=>"table",
							"map"=>array(
											"Deck Type"=>array("dec"=>array(
																				"", "Strength Deck", "Second Deck", "Third Deck", "Fourth Deck", "Fifth Deck"
																			),
																"spc"=>array(
																				"","Fore Castle Deck", "Poop Deck", "Boat Deck", "Bridge Deck", "Wheel House Deck", "Top Deck"
																			)
																)
										),
							"table"=>"dck",
							"search"=>"project",
							"limit"=>4,
							"checklist"=>true,
							"family"=>false
						),
					array(
							"id"=>"eqp",
							"item"=>array(
											"",
											array("name"=>"Bower Anchors","title"=>"Qty-Length-Type-Weight-Option-Manufacturer-Certificate"),
											array("name"=>"Stream Anchors","title"=>"Qty-Length-Type-Weight-Option-Manufacturer-Certificate"),
											array("name"=>"Bower Anchors Chain Cables","title"=>"Qty-Length-Grade-Diameter-Option-Manufacturer-Certificate"),
											array("name"=>"Stream Anchors Chain Cables","title"=>"Qty-Length-Grade-Diameter-Option-Manufacturer-Certificate"),
											array("name"=>"Tow Line","title"=>"Qty-Length-Material-Diameter-Option-Manufacturer-Certificate"),
											array("name"=>"Mooring Line","title"=>"Qty-Length-Material-Diameter-Option-Manufacturer-Certificate")
										 ),
							"type"=>"field",
							"map"=>array("Option"=>array(
															"with"=>"With stud",
															"without"=>"Without stud",
															"wire"=>"Steel wire rope",
															"chain"=>"Chain cable"
														)
										),
							"table"=>"eqp",
							"search"=>"alltype",
							"limit"=>3,
							"checklist"=>false,
							"family"=>false
						),
					array(
							"id"=>"rdc",
							"item"=>array(
											"",
											array("name"=>"Rudder Blade","title"=>"Qty-Size-Material-Thickness-Certificate-Flange"),
											array("name"=>"Rudder Stock","title"=>"Qty-Size-Material-Thickness-Certificate-Flange"),
											array("name"=>"Rudder Pintle","title"=>"Qty-Size-Material-Thickness-Certificate-Flange"),
											array("name"=>"Rudder Fit Bolts","title"=>"Qty-Size-Material-Thickness-Certificate-Flange"),
											array("name"=>"Carrier Bearing","title"=>"Qty-Size-Material-Thickness-Certificate-Flange"),
											array("name"=>"Neck Bearing","title"=>"Qty-Size-Material-Thickness-Certificate-Flange"),
											array("name"=>"Upper Pintle Bearing","title"=>"Qty-Size-Material-Thickness-Certificate-Flange"),
											array("name"=>"Lower Pintle Bearing","title"=>"Qty-Size-Material-Thickness-Certificate-Flange"),
											array("name"=>"Bottom Pintle Bearing","title"=>"Qty-Size-Material-Thickness-Certificate-Flange")
										),
							"type"=>"field",
							"map"=>array(),
							"table"=>"rudder",
							"search"=>"alltype",
							"limit"=>4,
							"checklist"=>false,
							"family"=>false
						),
					array(
							"id"=>"cgh",
							"item"=>array(
											"",
											array("name"=>"Mast","title"=>"Qty-Size-Manufacturer-Certificate"),
											array("name"=>"Derrick Boom","title"=>"Qty-SWL-Manufacturer-Certificate"),
											array("name"=>"Crane","title"=>"Qty-SWL-Manufacturer-Certificate")
										),
							"type"=>"field",
							"map"=>array(),
							"table"=>"cargo",
							"search"=>"alltype",
							"limit"=>4,
							"checklist"=>false,
							"family"=>false
						),
					array(
							"id"=>"meg",
							"item"=>"Brand-Type-Qty-Power-Revolution-Cyllinder-Bore x Stroke-Stroke-Year-Serial No-Certificate No-Manufacturer-Starting-Accessories",
							"type"=>"mix",
							"map"=>array(
											"Starting"=>array(
																"air"=>"Air",
																"batt"=>"Battery"
															),
											"Accessories"=>array(
																	"name"=>"Item-Type/Purpose-Qty",
																	"Item"=>array(
																					"",
																					"Turbocharger",
																					"Intercooler",
																					"Aux Blower",
																					"Attached Pumps",
																					"Attached Coolers",
																					"Attached Heaters",
																					"Flexible Coupling",
																					"Clutch",
																					)
																)
										),
							"table"=>"meg",
							"search"=>"alltype",
							"limit"=>3,
							"checklist"=>false,
							"family"=>false
						),
					array(
							"id"=>"trs",
							"item"=>"Dimension-Qty-Bearing qty-Material-Manufacturer-Certificate-Year-Brand-Type-Power-Revolution-Reduction Ratio-Bolt Type",
							"type"=>"field",
							"map"=>array(
											"Bolt Type"=>array(
																	"ME"=>"Main engine foundation fit bolt",
																	"GB"=>"Gear box foundation fit bolt",
																	"PI"=>"Propeller shaft coupling with intermediate shaft coupling",
																	"IG"=>"Intermediate shaft coupling with gear box shaft coupling",
																	"PG"=>"Propeller shaft coupling with gear box shaft coupling",
																	"II"=>"Intermediate shaft coupling with Intermediate shaft coupling"
																)
										),
							"table"=>"trs",
							"search"=>"project",
							"limit"=>5,
							"checklist"=>true,
							"family"=>false
						),
					array(
							"id"=>"prs",
							"item"=>array(
											"snb"=>array(
															"name"=>"Stern Tube",
															"title"=>"Qty-Lubricating System-Inside Diameter-Length-Sealing Device-Bearing Material-Bearing Length Fwd-Bearing Length Aft-Certificate"
														),
											"sfk"=>array(
															"name"=>"Shaft Bracket",
															"title"=>"Qty-Dimension-Bearing Material-Length-Sealing Device"
														),
											"psf"=>array(
															"name"=>"Propeller Shaft",
															"title"=>"Qty-Type-Material-Diameter-Length-Shaft Sleeve-Thickness-Year-Manufacturer-Certificate-Pasak"
														)
											),
							"type"=>"field",
							"map"=>array("Pasak"=>array("Without", "With")),
							"table"=>"prs",
							"search"=>"alltype",
							"limit"=>5,
							"checklist"=>false,
							"family"=>false
						),
					array(
							"id"=>"prp",
							"item"=>"Qty-Type-Blade Qty-Rotation-Weight-Material-Blade area-Diameter-Pitch-Manufacturer-Serial No-Year-Certificate",
							"type"=>"field",
							"map"=>array("Rotation"=>array(
														"L"=>"Left-handed",
														"R"=>"Right-handed"
														)
										),
							"table"=>"prp",
							"search"=>"alltype",
							"limit"=>4,
							"checklist"=>false,
							"family"=>false
						),
					array(
							"id"=>"aeg",
							"item"=>"Brand-Type-Qty-Power-Revolution-Manufacturer-Year-Certificate-Cylinder-Serial No-Voltage-Current-Frequency-Engine Power",
							"type"=>"field",
							"map"=>array(
											"Type"=>array(
																"AC"=>"Alternating Current",
																"DC"=>"Direct Current"
															)
										),
							"table"=>"aeg",
							"search"=>"project",
							"limit"=>4,
							"checklist"=>true,
							"family"=>false
						),
					array(
							"id"=>"mac+pmp",
							"item"=>"Qty-Brand-Year-Certificate No-Type-Head-Capacity-Power-Area-Pressure-Propeller-Blade-Dimension-Prime Mover-Prime Mover Type-Serial No-Location-Protection-Level Gauge-Setting Pressure",
							"type"=>"table",
							"map"=>array(
											"Type"=>array(
																"EH"=>"Electrical Heater",
																"SH"=>"Steam Heater",
																"TH"=>"Thermal Oil Heater"
															)
										),
							"table"=>"machinery",
							"search"=>"project",
							"limit"=>5,
							"checklist"=>true,
							"family"=>true
						),
					array(
							"id"=>"eln",
							"item"=>"Brand-Type-Capacity-Voltage-Current-Frequency-Year-Certificate-Diameter",
							"type"=>"field",
							"map"=>array(
											"Type"=>array(
																"SYC"=>"Synchronizing",
																"IND"=>"Independent"
															)
										),
							"table"=>"eln",
							"search"=>"project",
							"limit"=>4,
							"checklist"=>true,
							"family"=>false
						),
					array(
							"id"=>"frf",
							"item"=>"Type-Volume-Quantity-Certificate",
							"type"=>"table",
							"map"=>array(
											"Type"=>array(
																"CO2"=>"CO2 Extinguisher",
																"HAL"=>"Halon Extinguisher",
																"FOA"=>"Foam Extinguisher",
																"DCF"=>"Deck Foam Extinguisher",
																"DCP"=>"Dry-Chemical Powder Extinguisher",
																"HEF"=>"High Expansion Foam Extinguisher",
																"PWS"=>"Pressure Water Spraying Extinguisher",
																"FHN"=>"Fire Hose and Nozzle"
															)
										),
							"table"=>"frf",
							"search"=>"project",
							"limit"=>4,
							"checklist"=>true,
							"family"=>false
						),
					);
?>