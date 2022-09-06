<?php
	define("LOL_API_KEY", "82d385f6-0d35-4614-bffe-a91065ba8788");
	define("LOL_ENDPOINT","https://na.api.pvp.net/api/lol/na/v2.5");
	define("API_VERSION", "2.5");

	/*
	* Purpose: 	Retrives Summoner ID by Summoner Name.
	* Inputs:
	*		$orderInProgress:  	Current Match Id
	*		$summoner_name:		Summoner name by which game is played
			$meta_key:			Value to save in
	*/
	function lolAPISummonerDetails( $orderInProgress, $summoner_name, $meta_key = 'summoner_id')
	{
		$region = strtolower(get_post_meta($orderInProgress, 'choose_server', true));
		$summoner_name = str_replace(' ', '', $summoner_name);
		$curl_URL = "https://$region.api.pvp.net/api/lol/$region/v1.4/summoner/by-name/$summoner_name?api_key=".LOL_API_KEY;
		$response_json = lol_curl_call($curl_URL);
		$response_decoded = json_decode($response_json, true);
		if(!empty($response_decoded))
		{
			foreach($response_decoded as $key => $val)
			{
				if($key == 'status')
					return array('error'=>true, 'message'=>$val['message'], 'error_code'=>$val['status_code']);
				else{
					update_post_meta($orderInProgress, $meta_key, $val['id']);
					return array('success'=>true, 'summoner_id'=>$val['id']);
				}
			}
		}
		return array('error'=>true, 'message'=>'Error in running API');
	}

	/*
	* Purpose: Retrives 10 Latest Games Played by Summoner ID.
	* Inputs:
	*		$orderInProgress:  	Current Match Id
	*		$summoner_id:		Summoner ID by which game is played
	*/
	function lolAPIMatchDetails( $orderInProgress, $summoner_id)
	{
		$region = strtolower(get_post_meta($orderInProgress, 'choose_server', true));
		$curl_URL = "https://$region.api.pvp.net/api/lol/$region/v1.3/game/by-summoner/$summoner_id/recent?api_key=".LOL_API_KEY;
		$response_json = lol_curl_call($curl_URL);
		$response_decoded = json_decode($response_json, true);
		if(!empty($response_decoded))
		{
			if(isset($response_decoded['status']))
				return array('error' => true, 'message' => $response_decoded['status']['message']);
			else{
				if(
					isset($response_decoded['games']) &&
					!empty($response_decoded['games'])
				){

					$processing_started = get_post_meta($orderInProgress, 'processing_started', true);
					$processing_completed = get_post_meta($orderInProgress, 'processing_completed', true);
					$boosting_type = get_post_meta($orderInProgress, 'boosting_type', true);
					$boosting_action = get_post_meta($orderInProgress, 'boosting_action', true);
					$matches_played = get_post_meta($orderInProgress, 'matches_played', true);
					if(empty($matches_played) || !is_array($matches_played))
						$matches_played = array();
					$new_matches = array();

					foreach($response_decoded['games'] as $games){
						if(!empty($processing_started) &&
							($processing_started < ($games['createDate']/1000) ) &&
							( empty($processing_completed) || $processing_completed > ($games['createDate']/1000) )
						){
							if($boosting_type == 'group'){
								$client_summoner_id = get_post_meta($orderInProgress, 'client_summoner_id', true);
								$players_array = array();
								foreach($games['fellowPlayers'] as $players){
									$players_array[] = $players['summonerId'];
								}
							}
							if($boosting_action == 'general-wins' && $boosting_type == 'solo' && $games['subType'] != 'NORMAL'){
								continue;
							} elseif($games['subType'] != 'RANKED_SOLO_5x5' && $boosting_action != 'general-wins' && $boosting_type != 'solo') {
								continue;
								}
							if(!isset($client_summoner_id) || in_array($client_summoner_id, $players_array) ){
								if(!isset($matches_played[$games['createDate']]) )
								{
									$new_matches[$games['createDate']]['summoner_id'] = $response_decoded['summonerId'];
									$new_matches[$games['createDate']]['game_id'] = $games['gameId'];
									$new_matches[$games['createDate']]['champion_id'] = $games['championId'];
									$new_matches[$games['createDate']]['wins'] = $games['stats']['win'];
									$new_matches[$games['createDate']]['create_date'] = $games['createDate'];
									$new_matches[$games['createDate']]['k'] = $games['stats']['championsKilled'];
									$new_matches[$games['createDate']]['d'] = $games['stats']['numDeaths'];
									$new_matches[$games['createDate']]['a'] = $games['stats']['assists'];
									$new_matches[$games['createDate']]['gold_spent'] = $games['stats']['goldSpent'];
									$new_matches[$games['createDate']]['minions'] = (int)$games['stats']['minionsKilled'] + (int)$games['stats']['neutralMinionsKilled'];
									for($i=0;$i<=6;$i++)
									{
										$new_matches[$games['createDate']]['items'][$i] = $games['stats']['item'.$i];
									}
									$new_matches[$games['createDate']]['spell1'] = $games['spell1'];
									$new_matches[$games['createDate']]['spell2'] = $games['spell2'];
								}
							}
						}
					}
					$merged = array_merge($new_matches, $matches_played);
					if(!empty($merged)){
						foreach($merged as $matches){
							$new_keys[] = $matches['create_date'];
						}
						$merged = array_combine($new_keys, $merged);
					}
					update_post_meta($orderInProgress, 'matches_played', $merged);
					update_post_meta($orderInProgress, 'last_api_run', time());
					return array('success'=>true, 'all_matches'=>$merged);
				}
			}
		}
		return array('error'=>true, 'message'=>'Error in running API');
	}

	/*
	* Purpose: 	Check Division Rank.
	* Inputs:
	*		$orderInProgress:  	Current Match Id
	*		$summoner_id:		Summoner ID by which game is played
	*/
	function lolAPICheckDivisionRank( $orderInProgress, $summoner_id )
	{
		$region = strtolower(get_post_meta($orderInProgress, 'choose_server', true));
		$curl_URL = "https://$region.api.pvp.net/api/lol/$region/v2.5/league/by-summoner/$summoner_id/entry?api_key=".LOL_API_KEY;
		$response_json = lol_curl_call($curl_URL);
		$response_decoded = json_decode($response_json, true);

		if(!empty($response_decoded))
		{
			foreach($response_decoded as $key => $val)
			{
				if($key == 'status')
					return array('error'=>true, 'message'=>$val['message'], 'error_code'=>$val['status_code']);
				else{
					global $resolveLeagues, $resolveDivisions;

					update_post_meta($orderInProgress, 'order_current_league', array_search(ucfirst(strtolower($val[0]['tier'])), $resolveLeagues));
					update_post_meta($orderInProgress, 'order_current_division', array_search($val[0]['entries'][0]['division'], $resolveDivisions));
					update_post_meta($orderInProgress, 'order_current_league_points', $val[0]['entries'][0]['leaguePoints']);

					return array('success'=>true);
				}
			}
		}
		return array('error'=>true, 'message'=>'Error in running API');
	}

	/*
	* Purpose: 	LOL Curl Execute
	* Inputs:
	*		$url:  	Curl URL
	*/
	function lol_curl_call($url)
	{
		//setting the curl parameters.
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);

		$response = curl_exec($ch);
		//closing the curl
		curl_close($ch);

		return $response;
	}
?>
