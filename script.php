<?php
function display_line($length)
{
	for ($i = 0; $i < $length; $i++)
	{ 
		$line = "+---";
		echo $line;
	}
	echo "+\n";
}

function create_board($x, $y, $coordonnees)
{
	$plateau;
	for ($i = 0; $i < $x ; $i++)
	{
		$plateau[$i][0] = "|";
		for ($j = 1; $j <= $y; $j++)
		{ 
			$plateau[$i][$j] = "   |";
		}
	}

	foreach ($coordonnees as $croix)
	{

		if ($croix[0] < 0 || $croix[1] < 0 || $croix[0] > count($plateau[0]) - 1 || $croix[1] > count($plateau))
		{
		}
		else
		{
			$plateau[$croix[1]][$croix[0] + 1] = " X |";
		}

	}
	return $plateau; 
}

function display_board($plateau, $x)
{
	foreach ($plateau as $line)
	{
		display_line($x);
		foreach ($line as $case)
		{
			echo $case;
		}
		echo "\n";
	}
	display_line($x);
}

function explode_coordonnees($input)
{
	$coordonnees = preg_replace('/[^0-9.]+/', ',', $input);
	$coordonnees = trim($coordonnees, ",");
	$coordonnees = explode(",", $coordonnees);
	return $coordonnees;
}

function check_coordonnees($coordonnees, $plateau)
{
	if ($coordonnees[0] < 0 || $coordonnees[1] < 0 || $coordonnees[0] > count($plateau[0]) - 1 || $coordonnees[1] > count($plateau))
	{
		return false;
	}
	else
	{
		return true;
	}
}

function check_cross($coordonnees, $plateau)
{
	if ($plateau[$coordonnees[1]][$coordonnees[0] + 1] == "   |")
	{
		return true;
	}
	else
	{
		return false;
	}
}

function action(&$plateau, $x)
{
	while ($input = readline())
	{
		switch ($input)
		{
			case (preg_match("/query \[\d+, \d+\]/ ", $input) ? true: false):
				$coordonnees = (explode_coordonnees($input));
				if (check_coordonnees($coordonnees, $plateau))
				{
					if (check_cross($coordonnees, $plateau))
					{
						echo "empty\n";
					}
					else
					{
						echo "full\n";
					}
				}
				break;

			case (preg_match("/add \[\d+, \d+\]/ ", $input) ? true: false):
				$coordonnees = (explode_coordonnees($input));
				if (check_coordonnees($coordonnees, $plateau) && check_cross($coordonnees, $plateau))
				{
					$plateau[$coordonnees[1]][$coordonnees[0] + 1] = " X |";
				}
				else if (!check_coordonnees($coordonnees, $plateau))
				{
					break;
				}
				else
				{
					echo "A cross already exists at this location\n";
				}
				break;

			case (preg_match("/remove \[\d+, \d+\]/ ", $input) ? true: false):
				$coordonnees = (explode_coordonnees($input));
				if (check_coordonnees($coordonnees, $plateau) && check_cross($coordonnees, $plateau))
				{
					echo "No cross exists at this location\n";
				}
				else
				{
					$plateau[$coordonnees[1]][$coordonnees[0] + 1] = "   |";
				}
				break;

			case "display":
				display_board($plateau, $x);
				break;
		}
	}
}

function colle($x, $y, $coordonnees)
{
	if ($x > 0 && $y > 0)
	{
		$plateau = create_board($y, $x, $coordonnees);
		display_board($plateau, $x);
		action($plateau, $x);
	}
}
?>