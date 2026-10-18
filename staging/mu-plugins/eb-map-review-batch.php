<?php
/**
 * Plugin Name: 복지지도 지역 검수 33건 적용 도구 (스테이징 전용)
 * Version: 1.0.0
 * Description: 미리 보기 후 관리자 승인으로 지역 분류만 저장하며 이전 값을 백업합니다.
 */
defined( 'ABSPATH' ) || exit;

function ebmrb_allowed() {
	return 'wordpress-1073525-6734075.cloudwaysapps.com' === strtolower( (string) wp_parse_url( get_option( 'home' ), PHP_URL_HOST ) )
		&& function_exists( 'eb_stg_on' ) && eb_stg_on();
}
function ebmrb_plan() {
	return json_decode( base64_decode( 'W3siaWQiOiJXTEYwMDAwNTIwMyIsIm5hbWUiOiLsoIDshozrk53suLUg7Jes7ISx7LKt7IaM64WEIOyDneumrOyaqe2SiCDsp4Dsm5AiLCJhcmVhIjoi6rK97IOB67aB64+EIOyyreyGoeq1sCIsInJlYXNvbiI6IuyngOybkOuMgOyDgeyXkCDssq3shqHqtbAg7KO87IaMIOyalOqxtCDrqoXsi5wuIOuMgOyDgSDshKTrqoXqs7wg7ISg7KCV6riw7KSA7J2YIOyekOqyqSDrrLjqtawg67aI7J287LmY64qUIOuzhOuPhCDtmZXsnbgg7ZWE7JqULiIsInVybCI6Imh0dHBzOi8vd3d3LmJva2ppcm8uZ28ua3Ivc3Npcy10YnUvdHdhdGFhL3dsZmFyZUluZm8vbW92ZVRXQVQ1MjAxMU0uZG8/d2xmYXJlSW5mb0lkPVdMRjAwMDA1MjAzJndsZmFyZUluZm9SZWxkQnp0cENkPTAyIiwic2MiOiJzZ2ciLCJzZCI6IjQ3IiwiciI6WyI0Nzc1MCJdfSx7ImlkIjoiV0xGMDAwMDU4MzIiLCJuYW1lIjoi6rWt66+87Jes6rCA7Lqg7ZWR7J6lIOyalOq4iCDqsJDrqbQiLCJhcmVhIjoi7KCE67aB7Yq567OE7J6Q7LmY64+EIOygleydjeyLnCIsInJlYXNvbiI6IuyEoOygleq4sOykgOyXkCDsoJXsnY3si5wg6rSA64K0IOuLpOyekOuFgCDsobDqsbQg66qF7IucLiIsInVybCI6Imh0dHBzOi8vd3d3LmJva2ppcm8uZ28ua3Ivc3Npcy10YnUvdHdhdGFhL3dsZmFyZUluZm8vbW92ZVRXQVQ1MjAxMU0uZG8/d2xmYXJlSW5mb0lkPVdMRjAwMDA1ODMyJndsZmFyZUluZm9SZWxkQnp0cENkPTAyIiwic2MiOiJzZ2ciLCJzZCI6IjUyIiwiciI6WyI1MjE4MCJdfSx7ImlkIjoiV0xGMDAwMDU0MzAiLCJuYW1lIjoi7JiB7JWE7KKF7J287KCc65Ox7KCE64u07JWE7J2064+M67O066+47KeA7JuQIiwiYXJlYSI6IuqyveyDgeu2geuPhCDsoITssrQiLCJyZWFzb24iOiLshJzruYTsiqQg7ISk66qF7JeQ7IScIOqyveyDgeu2geuPhCDrgrQg64+M67SEIO2ZnOuPmSDsmpTqsbQg7ZmV7J24LiDsmrjrponqtbDsnLzroZwg7KKB7Z6I7KeAIOyViuydjC4iLCJ1cmwiOiJodHRwczovL3d3dy5ib2tqaXJvLmdvLmtyL3NzaXMtdGJ1L3R3YXRhYS93bGZhcmVJbmZvL21vdmVUV0FUNTIwMTFNLmRvP3dsZmFyZUluZm9JZD1XTEYwMDAwNTQzMCZ3bGZhcmVJbmZvUmVsZEJ6dHBDZD0wMiIsInNjIjoic2lkbyIsInNkIjoiNDciLCJyIjpbXX0seyJpZCI6IldMRjAwMDA1MzY0IiwibmFtZSI6Iuqyveq4sOuPhCDsnqXslaDsnbgg64yA7IaM67OA7Z2h7IiY7Jqp7ZKIIOq1rOyeheyngOybkCIsImFyZWEiOiLqsr3quLDrj4Qg7KCE7LK0IiwicmVhc29uIjoi7KeA7JuQ64yA7IOB7JeQIOqyveq4sOuPhCDqsbDso7wg65Ox66Gd7J6l7JWg7J24IOuqheyLnC4g7JWI7JaR7Iuc66GcIOyige2eiOyngCDslYrsnYwuIiwidXJsIjoiaHR0cHM6Ly93d3cuYm9ramlyby5nby5rci9zc2lzLXRidS90d2F0YWEvd2xmYXJlSW5mby9tb3ZlVFdBVDUyMDExTS5kbz93bGZhcmVJbmZvSWQ9V0xGMDAwMDUzNjQmd2xmYXJlSW5mb1JlbGRCenRwQ2Q9MDIiLCJzYyI6InNpZG8iLCJzZCI6IjQxIiwiciI6W119LHsiaWQiOiJXTEYwMDAwNTI4NyIsIm5hbWUiOiLsgrDrqqjsi6Dsg53slYQg6rG06rCV6rSA66asIOyngOybkCDtmZXrjIAo67O47J2467aA64u06riIIOyngOybkCkiLCJhcmVhIjoi6rK97IOB64Ko64+EIOyghOyytCIsInJlYXNvbiI6IuyngOybkOuMgOyDgeqzvCDshKDsoJXquLDspIAg66qo65GQIOyCsOuqqMK37Lac7IKw7JWE7J2YIOqyveyDgeuCqOuPhCDso7zshowg7JqU6rG0LiDrsIDslpHsi5wg7ZWc7KCVIOyVhOuLmC4iLCJ1cmwiOiJodHRwczovL3d3dy5ib2tqaXJvLmdvLmtyL3NzaXMtdGJ1L3R3YXRhYS93bGZhcmVJbmZvL21vdmVUV0FUNTIwMTFNLmRvP3dsZmFyZUluZm9JZD1XTEYwMDAwNTI4NyZ3bGZhcmVJbmZvUmVsZEJ6dHBDZD0wMiIsInNjIjoic2lkbyIsInNkIjoiNDgiLCJyIjpbXX0seyJpZCI6IldMRjAwMDAwMjMwIiwibmFtZSI6IuqzoO2dpeq1sCDqsrDtmLzsnqXroKTquIgg7KeA7JuQIiwiYXJlYSI6IuyghOuCqOq0keyjvO2Gte2Vqe2KueuzhOyLnCDqs6DtnaXqtbAiLCJyZWFzb24iOiLrs7jrrLjsl5Ag6rOg7Z2l6rWwIOyjvOyGjCDsnKDsp4DsmYAg64uo6rOE67OEIOyngOq4iSDsmpTqsbQg66qF7IucLiIsInVybCI6Imh0dHBzOi8vd3d3LmJva2ppcm8uZ28ua3Ivc3Npcy10YnUvdHdhdGFhL3dsZmFyZUluZm8vbW92ZVRXQVQ1MjAxMU0uZG8/d2xmYXJlSW5mb0lkPVdMRjAwMDAwMjMwJndsZmFyZUluZm9SZWxkQnp0cENkPTAyIiwic2MiOiJzZ2ciLCJzZCI6IjEyIiwiciI6WyIxMjc0MCJdfSx7ImlkIjoiV0xGMDAwMDEwMjIiLCJuYW1lIjoi7IKw66qo7Iug7IOd7JWEIOqxtOqwleq0gOumrOyCrCDsp4Dsm5Ag7ZmV64yAIiwiYXJlYSI6Iuqyveq4sOuPhCDsmKTsgrDsi5wiLCJyZWFzb24iOiLsi6Dssq0g7IucIOyCsOuqqOydmCDsmKTsgrDsi5wg7KO866+865Ox66GdIOyalOqxtCDrqoXsi5wuIiwidXJsIjoiaHR0cHM6Ly93d3cuYm9ramlyby5nby5rci9zc2lzLXRidS90d2F0YWEvd2xmYXJlSW5mby9tb3ZlVFdBVDUyMDExTS5kbz93bGZhcmVJbmZvSWQ9V0xGMDAwMDEwMjImd2xmYXJlSW5mb1JlbGRCenRwQ2Q9MDIiLCJzYyI6InNnZyIsInNkIjoiNDEiLCJyIjpbIjQxMzcwIl19LHsiaWQiOiJXTEYwMDAwMDI4MyIsIm5hbWUiOiLtmZTshLHsi5wg66y07Jew6rOgIOyCrOunneyekCDsnqXsoJzsspjrpqwiLCJhcmVhIjoi6rK96riw64+EIO2ZlOyEseyLnCIsInJlYXNvbiI6IuyngOybkOuMgOyDgeyXkCDtmZTshLHsi5wg6rSA7ZWgIOq1rOyXreydmCDsi5zsi6DsnbTrnbzqs6Ag66qF7IucLiDqsbDso7zrr7wg7KeA7JuQ6rO864qUIOuLpOuluCDqtIDtlaAg7KGw6rG0LiIsInVybCI6Imh0dHBzOi8vd3d3LmJva2ppcm8uZ28ua3Ivc3Npcy10YnUvdHdhdGFhL3dsZmFyZUluZm8vbW92ZVRXQVQ1MjAxMU0uZG8/d2xmYXJlSW5mb0lkPVdMRjAwMDAwMjgzJndsZmFyZUluZm9SZWxkQnp0cENkPTAyIiwic2MiOiJzZ2ciLCJzZCI6IjQxIiwiciI6WyI0MTU5MCJdfSx7ImlkIjoiV0xGMDAwMDU4NTEiLCJuYW1lIjoi64aN7LSM7Jyg7ZWZIOyngOybkOyCrOyXhSIsImFyZWEiOiLsoITrgqjqtJHso7zthrXtlantirnrs4Tsi5wg7JiB6rSR6rWwIiwicmVhc29uIjoi7JiB6rSR6rWwIO2Vmeq1kOuhnCDsoITtlZkg67CPIOyjvOyGjCDsnbTsoIQg7KGw6rG0LiDsmbjsp4Ag7ZWZ7IOd64+EIOyLoOyyrSDqsIDriqXtlZjrr4DroZwg7ZiEIOqxsOyjvOuvvCDtlZzsoJUg7ZGc7IucIOq4iOyngC4iLCJ1cmwiOiJodHRwczovL3d3dy5ib2tqaXJvLmdvLmtyL3NzaXMtdGJ1L3R3YXRhYS93bGZhcmVJbmZvL21vdmVUV0FUNTIwMTFNLmRvP3dsZmFyZUluZm9JZD1XTEYwMDAwNTg1MSZ3bGZhcmVJbmZvUmVsZEJ6dHBDZD0wMiIsInNjIjoic2dnIiwic2QiOiIxMiIsInIiOlsiMTI4MzAiXX0seyJpZCI6IldMRjAwMDA0MTQ1IiwibmFtZSI6Iuq1sO2PrOyLnCDspJHCt+qzoOuTse2Vmeq1kCDsi6DsnoXsg50g6rWQ67O16rWs7J6F67mEIOyngOybkOyCrOyXhSIsImFyZWEiOiLqsr3quLDrj4Qg6rWw7Y+s7IucIiwicmVhc29uIjoi7KeA7JuQ64yA7IOB6rO8IOyEoOygleq4sOykgOyXkCDqtbDtj6zsi5wg7KO866+865Ox66GdIOyalOqxtCDrqoXsi5wuIiwidXJsIjoiaHR0cHM6Ly93d3cuYm9ramlyby5nby5rci9zc2lzLXRidS90d2F0YWEvd2xmYXJlSW5mby9tb3ZlVFdBVDUyMDExTS5kbz93bGZhcmVJbmZvSWQ9V0xGMDAwMDQxNDUmd2xmYXJlSW5mb1JlbGRCenRwQ2Q9MDIiLCJzYyI6InNnZyIsInNkIjoiNDEiLCJyIjpbIjQxNDEwIl19LHsiaWQiOiJXTEYwMDAwNDI0MiIsIm5hbWUiOiLssLjsoITrqoXsmIjsiJjri7kiLCJhcmVhIjoi6rK97IOB67aB64+EIOyauOynhOq1sCIsInJlYXNvbiI6IuuMgOyDgSDrs7jrrLjsl5Ag7Jq47KeE6rWwIOyjvOyGjCDsobDqsbQg66qF7IucLiIsInVybCI6Imh0dHBzOi8vd3d3LmJva2ppcm8uZ28ua3Ivc3Npcy10YnUvdHdhdGFhL3dsZmFyZUluZm8vbW92ZVRXQVQ1MjAxMU0uZG8/d2xmYXJlSW5mb0lkPVdMRjAwMDA0MjQyJndsZmFyZUluZm9SZWxkQnp0cENkPTAyIiwic2MiOiJzZ2ciLCJzZCI6IjQ3IiwiciI6WyI0NzkzMCJdfSx7ImlkIjoiV0xGMDAwMDE4NTYiLCJuYW1lIjoi7J6l7JWg7J2467O07KGw6riw6rWs7IiY66as7IKs7JeFIiwiYXJlYSI6IuyEnOyauO2KueuzhOyLnCDqsJXrtoHqtawiLCJyZWFzb24iOiLrjIDsg4Eg67O466y47JeQIOqwleu2geq1rCDrk7HroZ3snqXslaDsnbgg7KGw6rG07J2EIOuwmOuztSDrqoXsi5wuIiwidXJsIjoiaHR0cHM6Ly93d3cuYm9ramlyby5nby5rci9zc2lzLXRidS90d2F0YWEvd2xmYXJlSW5mby9tb3ZlVFdBVDUyMDExTS5kbz93bGZhcmVJbmZvSWQ9V0xGMDAwMDE4NTYmd2xmYXJlSW5mb1JlbGRCenRwQ2Q9MDIiLCJzYyI6InNnZyIsInNkIjoiMTEiLCJyIjpbIjExMzA1Il19LHsiaWQiOiJXTEYwMDAwMTIxMyIsIm5hbWUiOiLsnqXslaDsnbjrs7TsobDquLDquLDsiJjrpqzsgqzsl4UiLCJhcmVhIjoi7ISc7Jq47Yq567OE7IucIOqwleu2geq1rCIsInJlYXNvbiI6IuyEoOygleq4sOykgOyXkCDqsJXrtoHqtawg65Ox66Gd7J6l7JWg7J24IOyhsOqxtCDrqoXsi5wuIOycoOyCrCDsgqzsl4Xqs7wg7KSR67O1IOyXrOu2gOuKlCDrs4Trj4Qg6rKA7IiYLiIsInVybCI6Imh0dHBzOi8vd3d3LmJva2ppcm8uZ28ua3Ivc3Npcy10YnUvdHdhdGFhL3dsZmFyZUluZm8vbW92ZVRXQVQ1MjAxMU0uZG8/d2xmYXJlSW5mb0lkPVdMRjAwMDAxMjEzJndsZmFyZUluZm9SZWxkQnp0cENkPTAyIiwic2MiOiJzZ2ciLCJzZCI6IjExIiwiciI6WyIxMTMwNSJdfSx7ImlkIjoiV0xGMDAwMDIwODQiLCJuYW1lIjoi64us7ISx6rWwIOy2nOyCsOy2le2VmOq4iCDsp4Dsm5AiLCJhcmVhIjoi64yA6rWs6rSR7Jet7IucIOuLrOyEseq1sCIsInJlYXNvbiI6Iuu2gOuqqOyZgCDstpzsg53slYTsnZgg64us7ISx6rWwIOyjvOuvvOuTseuhnSDrsI8g6rGw7KO8IOyhsOqxtCDrqoXsi5wuIiwidXJsIjoiaHR0cHM6Ly93d3cuYm9ramlyby5nby5rci9zc2lzLXRidS90d2F0YWEvd2xmYXJlSW5mby9tb3ZlVFdBVDUyMDExTS5kbz93bGZhcmVJbmZvSWQ9V0xGMDAwMDIwODQmd2xmYXJlSW5mb1JlbGRCenRwQ2Q9MDIiLCJzYyI6InNnZyIsInNkIjoiMjciLCJyIjpbIjI3NzEwIl19LHsiaWQiOiJXTEYwMDAwMzk1OSIsIm5hbWUiOiLriITrpqzqs7zsoJUo66eMM3417IS4KSDrtoDrqqjrtoDri7Qg67O07Jyh66OMIOyngOybkCIsImFyZWEiOiLqsr3sg4Hrgqjrj4Qg7Ya17JiB7IucIiwicmVhc29uIjoi7Ya17JiB7IucIOyGjOyerCDslrTrprDsnbTsp5Eg7J207JqpIOyVhOuPmSDsobDqsbQg66qF7IucLiDslYTrj5nsnZgg6rGw7KO87KeAIOyhsOqxtOqzvCDtmLzrj5ntlZjsp4Ag7JWK7J2MLiIsInVybCI6Imh0dHBzOi8vd3d3LmJva2ppcm8uZ28ua3Ivc3Npcy10YnUvdHdhdGFhL3dsZmFyZUluZm8vbW92ZVRXQVQ1MjAxMU0uZG8/d2xmYXJlSW5mb0lkPVdMRjAwMDAzOTU5JndsZmFyZUluZm9SZWxkQnp0cENkPTAyIiwic2MiOiJzZ2ciLCJzZCI6IjQ4IiwiciI6WyI0ODIyMCJdfSx7ImlkIjoiV0xGMDAwMDQzNzUiLCJuYW1lIjoi7IKw66qo7Iug7IOd7JWE6rG06rCV6rSA66as7KeA7JuQ7IKs7JeFIOuzuOyduOu2gOuLtOq4iOyngOybkCIsImFyZWEiOiLqsr3sg4Hrgqjrj4Qg6rmA7ZW07IucIiwicmVhc29uIjoi64yA7IOBIOuzuOusuOyXkCDquYDtlbTsi5wg7KO866+865Ox66GdIOuYkOuKlCDsmbjqta3snbjrk7HroZ0g7KGw6rG0IOuqheyLnC4iLCJ1cmwiOiJodHRwczovL3d3dy5ib2tqaXJvLmdvLmtyL3NzaXMtdGJ1L3R3YXRhYS93bGZhcmVJbmZvL21vdmVUV0FUNTIwMTFNLmRvP3dsZmFyZUluZm9JZD1XTEYwMDAwNDM3NSZ3bGZhcmVJbmZvUmVsZEJ6dHBDZD0wMiIsInNjIjoic2dnIiwic2QiOiI0OCIsInIiOlsiNDgyNTAiXX0seyJpZCI6IldMRjAwMDA1MTEyIiwibmFtZSI6IuqyveyDgeuCqOuPhCDssq3rhYQg7JuU7IS4IOyngOybkOyCrOyXhSIsImFyZWEiOiLqsr3sg4Hrgqjrj4Qg6rGw7KCc7IucIiwicmVhc29uIjoi7KeA7JuQ64yA7IOB7JeQIOqxsOygnOyLnCDso7zshowg67CPIOqxsOygnOyLnCDso7ztg50g7J6E64yA7LCoIOyalOqxtCDrqoXsi5wuIiwidXJsIjoiaHR0cHM6Ly93d3cuYm9ramlyby5nby5rci9zc2lzLXRidS90d2F0YWEvd2xmYXJlSW5mby9tb3ZlVFdBVDUyMDExTS5kbz93bGZhcmVJbmZvSWQ9V0xGMDAwMDUxMTImd2xmYXJlSW5mb1JlbGRCenRwQ2Q9MDIiLCJzYyI6InNnZyIsInNkIjoiNDgiLCJyIjpbIjQ4MzEwIl19LHsiaWQiOiJXTEYwMDAwNDA3MSIsIm5hbWUiOiLsgrDrqqjCt+yLoOyDneyVhCDqsbTqsJXqtIDrpqzshJzruYTsiqQg7KeA7JuQ7IKs7JeFIiwiYXJlYSI6IuqyveyDgeuCqOuPhCDquYDtlbTsi5wiLCJyZWFzb24iOiLsp4Dsm5DrjIDsg4Hqs7wg7ISg7KCV6riw7KSA7JeQIOq5gO2VtOyLnCDrk7HroZ0g7Lac7IKw6rCA7KCVIOuqheyLnC4iLCJ1cmwiOiJodHRwczovL3d3dy5ib2tqaXJvLmdvLmtyL3NzaXMtdGJ1L3R3YXRhYS93bGZhcmVJbmZvL21vdmVUV0FUNTIwMTFNLmRvP3dsZmFyZUluZm9JZD1XTEYwMDAwNDA3MSZ3bGZhcmVJbmZvUmVsZEJ6dHBDZD0wMiIsInNjIjoic2dnIiwic2QiOiI0OCIsInIiOlsiNDgyNTAiXX0seyJpZCI6IldMRjAwMDAxODk5IiwibmFtZSI6IuuPheumveycoOqzteyekCDsnZjro4zruYQg7KeA7JuQIiwiYXJlYSI6IuqyveyDgeuCqOuPhCDsoITssrQiLCJyZWFzb24iOiLshKDsoJXquLDspIDsnYAg64+E64K0IOycoOyhseydtOupsCDsm5DrrLgg7Jew65297LKY64+EIOqyveyDgeuCqOuPhCDrs7Xsp4DsoJXssYXqs7wuIOynhOyjvOyLnOuhnCDsooHtnojsp4Ag7JWK7J2MLiIsInVybCI6Imh0dHBzOi8vd3d3LmJva2ppcm8uZ28ua3Ivc3Npcy10YnUvdHdhdGFhL3dsZmFyZUluZm8vbW92ZVRXQVQ1MjAxMU0uZG8/d2xmYXJlSW5mb0lkPVdMRjAwMDAxODk5JndsZmFyZUluZm9SZWxkQnp0cENkPTAyIiwic2MiOiJzaWRvIiwic2QiOiI0OCIsInIiOltdfSx7ImlkIjoiV0xGMDAwMDY3MTkiLCJuYW1lIjoi7IS47Ke47JWEIOycoeyVhOyaqe2SiCDsp4Dsm5Dsgqzsl4UiLCJhcmVhIjoi7KCE67aB7Yq567OE7J6Q7LmY64+EIOyghOyytCIsInJlYXNvbiI6IuyLoOyyreyekOqyqeyXkCDsoITrnbzrtoHrj4Qg7KO866+865Ox66GdIOyhsOqxtCDrqoXsi5wuIOygleydjeyLnCDtlZzsoJUg7LaU7LKc6rO8IOq1rOu2hC4g7Jyg7IKsIOygleydjeyLnCDsgqzsl4Xqs7wg7KSR67O1IOqygOyImCDtlYTsmpQuIiwidXJsIjoiaHR0cHM6Ly93d3cuYm9ramlyby5nby5rci9zc2lzLXRidS90d2F0YWEvd2xmYXJlSW5mby9tb3ZlVFdBVDUyMDExTS5kbz93bGZhcmVJbmZvSWQ9V0xGMDAwMDY3MTkmd2xmYXJlSW5mb1JlbGRCenRwQ2Q9MDIiLCJzYyI6InNpZG8iLCJzZCI6IjUyIiwiciI6W119LHsiaWQiOiJXTEYwMDAwMTQ1MSIsIm5hbWUiOiLssq3rhYQg7Ja07ZWZwrfsnpDqsqnsi5ztl5gg7J2R7Iuc66OMIOyngOybkOyCrOyXhSIsImFyZWEiOiLqsr3quLDrj4Qg7JWI7JaR7IucIiwicmVhc29uIjoi7Iuc7ZeY67aA7YSwIOyLoOyyreq5jOyngCDslYjslpHsi5wg6rGw7KO8IOyhsOqxtCDrqoXsi5wuIiwidXJsIjoiaHR0cHM6Ly93d3cuYm9ramlyby5nby5rci9zc2lzLXRidS90d2F0YWEvd2xmYXJlSW5mby9tb3ZlVFdBVDUyMDExTS5kbz93bGZhcmVJbmZvSWQ9V0xGMDAwMDE0NTEmd2xmYXJlSW5mb1JlbGRCenRwQ2Q9MDIiLCJzYyI6InNnZyIsInNkIjoiNDEiLCJyIjpbIjQxMTcwIl19LHsiaWQiOiJXTEYwMDAwNDc5MiIsIm5hbWUiOiLsg53tmZzssrTsnKHqtZDsi6Qg7Jq07JiBIOyngOybkCIsImFyZWEiOiLqsr3sg4HrtoHrj4Qg7IOB7KO87IucIiwicmVhc29uIjoi7IOB7KO87IucIOuPme2YuOyduCDrsI8g7IOB7KO87Iuc7LK07Jyh7ZqMIOyCsO2VmCDtmozsm5Ag7KGw6rG0IOuqheyLnC4iLCJ1cmwiOiJodHRwczovL3d3dy5ib2tqaXJvLmdvLmtyL3NzaXMtdGJ1L3R3YXRhYS93bGZhcmVJbmZvL21vdmVUV0FUNTIwMTFNLmRvP3dsZmFyZUluZm9JZD1XTEYwMDAwNDc5MiZ3bGZhcmVJbmZvUmVsZEJ6dHBDZD0wMiIsInNjIjoic2dnIiwic2QiOiI0NyIsInIiOlsiNDcyNTAiXX0seyJpZCI6IldMRjAwMDA1NDQxIiwibmFtZSI6IuyEnOyauO2KueuzhOyLnCDshJzsmrjtmJUg7YKk7KaI7Lm07Y6YIOyLnOumvSDrmp3shKwg7J6Q67KM66CI7KCQIOyatOyYgSIsImFyZWEiOiLshJzsmrjtirnrs4Tsi5wg7KCE7LK0IiwicmVhc29uIjoi64yA7IOB7JeQIOyEnOyauOyLnCDqsbDso7wg7JWE64+Zwrfrs7TtmLjsnpAg66qF7IucLiDsi5zshKTsnbQg6rSR7KeE6rWs7JeQIOyeiOyWtOuPhCDqtJHsp4Tqtazrr7wg7ZWc7KCVIOyVhOuLmC4iLCJ1cmwiOiJodHRwczovL3d3dy5ib2tqaXJvLmdvLmtyL3NzaXMtdGJ1L3R3YXRhYS93bGZhcmVJbmZvL21vdmVUV0FUNTIwMTFNLmRvP3dsZmFyZUluZm9JZD1XTEYwMDAwNTQ0MSZ3bGZhcmVJbmZvUmVsZEJ6dHBDZD0wMiIsInNjIjoic2lkbyIsInNkIjoiMTEiLCJyIjpbXX0seyJpZCI6IldMRjAwMDA1NzUzIiwibmFtZSI6IuyEseu2geq1rCDshJzsmrjtmJUg7YKk7KaI7Lm07Y6YIOyatOyYgSIsImFyZWEiOiLshJzsmrjtirnrs4Tsi5wg7KCE7LK0IiwicmVhc29uIjoi64yA7IOB7JeQIOyEnOyauOyLnCDqsbDso7zrv5Ag7JWE64uI6528IOyDne2ZnOq2jCDtj6ztlagg66qF7IucLiDshLHrtoHqtazrr7zrp4zsnLzroZwg7KKB7Z6I7KeAIOyViuydjC4iLCJ1cmwiOiJodHRwczovL3d3dy5ib2tqaXJvLmdvLmtyL3NzaXMtdGJ1L3R3YXRhYS93bGZhcmVJbmZvL21vdmVUV0FUNTIwMTFNLmRvP3dsZmFyZUluZm9JZD1XTEYwMDAwNTc1MyZ3bGZhcmVJbmZvUmVsZEJ6dHBDZD0wMiIsInNjIjoic2lkbyIsInNkIjoiMTEiLCJyIjpbXX0seyJpZCI6IldMRjAwMDA1ODA5IiwibmFtZSI6IuyXrOyImOyLnCDstpzsg53quLDrs7jshozrk50iLCJhcmVhIjoi7KCE64Ko6rSR7KO87Ya17ZWp7Yq567OE7IucIOyXrOyImOyLnCIsInJlYXNvbiI6IuuMgOyDgeqzvCDsp4DquInsmpTqsbTsl5Ag7Jes7IiY7IucIOyjvOyGjCDsobDqsbQg66qF7IucLiDthrXtlakg66qF7Lmt7J20IOyeiOyWtOuPhCDsgqzsl4Ug67KU7JyEIO2ZleuMgCDquIjsp4AuIiwidXJsIjoiaHR0cHM6Ly93d3cuYm9ramlyby5nby5rci9zc2lzLXRidS90d2F0YWEvd2xmYXJlSW5mby9tb3ZlVFdBVDUyMDExTS5kbz93bGZhcmVJbmZvSWQ9V0xGMDAwMDU4MDkmd2xmYXJlSW5mb1JlbGRCenRwQ2Q9MDIiLCJzYyI6InNnZyIsInNkIjoiMTIiLCJyIjpbIjEyMTMwIl19LHsiaWQiOiJXTEYwMDAwMTY2NyIsIm5hbWUiOiLsnqXslaDsnbgg6rG06rCV6rWQ7IukIOyatOyYgSIsImFyZWEiOiLstqnssq3rgqjrj4Qg67O066C57IucIiwicmVhc29uIjoi7KeA7JuQ64yA7IOB6rO8IOyEoOygleq4sOykgOyXkCDrs7TroLnsi5wg7KO866+865Ox66GdIOyhsOqxtCDrqoXsi5wuIiwidXJsIjoiaHR0cHM6Ly93d3cuYm9ramlyby5nby5rci9zc2lzLXRidS90d2F0YWEvd2xmYXJlSW5mby9tb3ZlVFdBVDUyMDExTS5kbz93bGZhcmVJbmZvSWQ9V0xGMDAwMDE2Njcmd2xmYXJlSW5mb1JlbGRCenRwQ2Q9MDIiLCJzYyI6InNnZyIsInNkIjoiNDQiLCJyIjpbIjQ0MTgwIl19LHsiaWQiOiJXTEYwMDAwNjE2NCIsIm5hbWUiOiIzNjVYMjQg7JWE64+Z64+M67SEIOqxsOygkOyEvO2EsCDsmrTsmIEiLCJhcmVhIjoi7Lap7LKt64Ko64+EIOyghOyytCIsInJlYXNvbiI6Iuy2qeuCqCDrj4TrgrQg7JWE64+ZIOuwjyDstqnrgqjsl5Ag67aA66qowrfsobDrtoDrqqjqsIAg7J6I64qUIOyVhOuPmSDsnbTsmqkg7KGw6rG0LiDslYTsgrDsi5zrp4zsnLzroZwg7ZWc7KCV7ZWY7KeAIOyViuydjC4iLCJ1cmwiOiJodHRwczovL3d3dy5ib2tqaXJvLmdvLmtyL3NzaXMtdGJ1L3R3YXRhYS93bGZhcmVJbmZvL21vdmVUV0FUNTIwMTFNLmRvP3dsZmFyZUluZm9JZD1XTEYwMDAwNjE2NCZ3bGZhcmVJbmZvUmVsZEJ6dHBDZD0wMiIsInNjIjoic2lkbyIsInNkIjoiNDQiLCJyIjpbXX0seyJpZCI6IldMRjAwMDA2MTExIiwibmFtZSI6Iuu2gOyCsO2YlSDsgrDtm4TsobDrpqzruYQg7KeA7JuQ7IKs7JeFIiwiYXJlYSI6Iuu2gOyCsOq0keyXreyLnCDsoITssrQiLCJyZWFzb24iOiLrjIDsg4Hqs7wg7ISg7KCV6riw7KSA7JeQIOu2gOyCsOyLnCDso7zrr7zrk7HroZ0g7KGw6rG0LiDrtoDsgrDsp4Tqtawg7ZWc7KCVIOy2lOyynOydgCDsoIHsmqntlZjsp4Ag7JWK7J2MLiIsInVybCI6Imh0dHBzOi8vd3d3LmJva2ppcm8uZ28ua3Ivc3Npcy10YnUvdHdhdGFhL3dsZmFyZUluZm8vbW92ZVRXQVQ1MjAxMU0uZG8/d2xmYXJlSW5mb0lkPVdMRjAwMDA2MTExJndsZmFyZUluZm9SZWxkQnp0cENkPTAyIiwic2MiOiJzaWRvIiwic2QiOiIyNiIsInIiOltdfSx7ImlkIjoiV0xGMDAwMDU3OTMiLCJuYW1lIjoi7ZWY7IiY64+E7JqU6riIIOqwkOuptCIsImFyZWEiOiLsoITrtoHtirnrs4TsnpDsuZjrj4Qg6rWw7IKw7IucIiwicmVhc29uIjoi7ISg7KCV6riw7KSA7JeQIOq1sOyCsOyLnCDsobDroYDsnZgg64uk7J6Q64WA6rCA7KCVIOyhsOqxtOqzvCDqtbDsgrDsi5wg7ZWY7IiY64+EIOyhsOuhgOulvCDsl7DqsrAuIiwidXJsIjoiaHR0cHM6Ly93d3cuYm9ramlyby5nby5rci9zc2lzLXRidS90d2F0YWEvd2xmYXJlSW5mby9tb3ZlVFdBVDUyMDExTS5kbz93bGZhcmVJbmZvSWQ9V0xGMDAwMDU3OTMmd2xmYXJlSW5mb1JlbGRCenRwQ2Q9MDIiLCJzYyI6InNnZyIsInNkIjoiNTIiLCJyIjpbIjUyMTMwIl19LHsiaWQiOiJXTEYwMDAwNTc5NCIsIm5hbWUiOiLshYvsp7jslYQg7J207IOBIOycoeyVhOyaqe2SiCDsp4Dsm5AiLCJhcmVhIjoi7KCE67aB7Yq567OE7J6Q7LmY64+EIOygleydjeyLnCIsInJlYXNvbiI6IuuMgOyDgeyXkCDsoJXsnY3si5wg6rGw7KO8IOyhsOqxtCDrqoXsi5wuIOq0keyXrSDsnKDsgqzsgqzsl4Xqs7wg6rWs67aEIOqygOyImCDtlYTsmpQuIiwidXJsIjoiaHR0cHM6Ly93d3cuYm9ramlyby5nby5rci9zc2lzLXRidS90d2F0YWEvd2xmYXJlSW5mby9tb3ZlVFdBVDUyMDExTS5kbz93bGZhcmVJbmZvSWQ9V0xGMDAwMDU3OTQmd2xmYXJlSW5mb1JlbGRCenRwQ2Q9MDIiLCJzYyI6InNnZyIsInNkIjoiNTIiLCJyIjpbIjUyMTgwIl19LHsiaWQiOiJXTEYwMDAwNTcxOCIsIm5hbWUiOiLsiJjsm5DtmJUg7Ya17ZWp64+M67SEIOyImOybkOyDiOu5m+uPjOu0hCjriITqtazrgpgpIOyCrOyXhSIsImFyZWEiOiLqsr3quLDrj4Qg7IiY7JuQ7IucIiwicmVhc29uIjoi64yA7IOB7JeQIOyImOybkCDsi6TqsbDso7zsnpDsmYAg7Jm46rWt7J24IOyhsOqxtCDrqoXsi5wuIOyjvOuvvOuTseuhnSDsobDqsbTrp4zsnLzroZwg7KKB7Z6I7KeAIOyViuydjC4iLCJ1cmwiOiJodHRwczovL3d3dy5ib2tqaXJvLmdvLmtyL3NzaXMtdGJ1L3R3YXRhYS93bGZhcmVJbmZvL21vdmVUV0FUNTIwMTFNLmRvP3dsZmFyZUluZm9JZD1XTEYwMDAwNTcxOCZ3bGZhcmVJbmZvUmVsZEJ6dHBDZD0wMiIsInNjIjoic2dnIiwic2QiOiI0MSIsInIiOlsiNDExMTAiXX0seyJpZCI6IldMRjAwMDA1NTg5IiwibmFtZSI6IuyWtOultOyLoCDrrLTsnoTqtZDthrUg7KeA7JuQIOyCrOyXhSIsImFyZWEiOiLqsr3sg4HrtoHrj4Qg6rK97IKw7IucIiwicmVhc29uIjoi7KeA7JuQ64yA7IOB7JeQIOqyveyCsOyLnCDqtIDrgrQg7KGw6rG0IOuqheyLnC4g7Jew64+E67OEIOyXsOuguSDquLDspIDsnYAg67OE64+E7J2066+A66GcIDcw7IS466GcIOydvOq0hCDslYjrgrTtlZjsp4Ag7JWK7J2MLiIsInVybCI6Imh0dHBzOi8vd3d3LmJva2ppcm8uZ28ua3Ivc3Npcy10YnUvdHdhdGFhL3dsZmFyZUluZm8vbW92ZVRXQVQ1MjAxMU0uZG8/d2xmYXJlSW5mb0lkPVdMRjAwMDA1NTg5JndsZmFyZUluZm9SZWxkQnp0cENkPTAyIiwic2MiOiJzZ2ciLCJzZCI6IjQ3IiwiciI6WyI0NzI5MCJdfSx7ImlkIjoiV0xGMDAwMDU0MDYiLCJuYW1lIjoi6rKw7Zi87J2066+87J6QIOy3qOyXheyngOybkCDsgqzsl4UiLCJhcmVhIjoi7KCE64Ko6rSR7KO87Ya17ZWp7Yq567OE7IucIOyInOyynOyLnCIsInJlYXNvbiI6IuyEoOygleq4sOykgOyXkCDsiJzsspzsi5wg6rGw7KO8IOyhsOqxtCDrqoXsi5wuIOybkOusuOydtCDsmKTrnpjrkJjslrQg7Jq07JiBIOyXrOu2gOuKlCDstpTqsIAg7ZmV7J24IO2VhOyalC4iLCJ1cmwiOiJodHRwczovL3d3dy5ib2tqaXJvLmdvLmtyL3NzaXMtdGJ1L3R3YXRhYS93bGZhcmVJbmZvL21vdmVUV0FUNTIwMTFNLmRvP3dsZmFyZUluZm9JZD1XTEYwMDAwNTQwNiZ3bGZhcmVJbmZvUmVsZEJ6dHBDZD0wMiIsInNjIjoic2dnIiwic2QiOiIxMiIsInIiOlsiMTIxNTAiXX1d' ), true );
}
function ebmrb_backup_key() { return 'ebmrb_backup_20261018_v1'; }
function ebmrb_check() {
	if ( ! ebmrb_allowed() || ! current_user_can( 'manage_options' ) || ! function_exists( 'ebm_data' ) || ! function_exists( 'ebm_flush_cache' ) ) {
		wp_die( '보호 파일이 켜진 스테이징의 관리자만 사용할 수 있습니다.' );
	}
}
function ebmrb_state() {
	$plan = ebmrb_plan();
	if ( ! is_array( $plan ) || 33 !== count( $plan ) ) { wp_die( '적용 목록이 올바르지 않습니다.' ); }
	$data = ebm_data();
	$review = ebm_review_all();
	$before = array();
	foreach ( $plan as $p ) {
		$it = $data['items'][ $p['id'] ] ?? null;
		if ( ! $it || $it['n'] !== $p['name'] || 'check' !== $it['sc'] || (string) $it['sd'] !== $p['sd'] ) {
			wp_die( '사업 이름·지역·검수 상태가 검수 당시와 다릅니다. 저장하지 않았습니다. 사업: ' . esc_html( $p['name'] ) );
		}
		if ( 'sgg' === $p['sc'] ) {
			$region = ebm_sgg( $p['r'][0] );
			if ( ! $region || $region['sd'] !== $p['sd'] || $region['sdn'] . ' ' . $region['n'] !== $p['area'] ) { wp_die( '지역 코드가 변경되어 중단했습니다.' ); }
		} else {
			$region = ebm_sido( $p['sd'] );
			if ( ! $region || $region['n'] . ' 전체' !== $p['area'] ) { wp_die( '시·도 코드가 변경되어 중단했습니다.' ); }
		}
		$before[ $p['id'] ] = array( 'exists' => array_key_exists( $p['id'], $review ), 'value' => $review[ $p['id'] ] ?? null );
	}
	return array( 'review' => $review, 'before' => $before, 'signature' => hash_hmac( 'sha256', wp_json_encode( array( $before, $plan ) ), wp_salt( 'nonce' ) ) );
}

add_action( 'admin_menu', function () {
	if ( ebmrb_allowed() ) {
		add_management_page( '복지지도 33건 적용', '복지지도 33건 적용', 'manage_options', 'ebmrb-batch', 'ebmrb_page' );
	}
} );
function ebmrb_page() {
	ebmrb_check();
	$backup = get_option( ebmrb_backup_key() );
	echo '<div class="wrap"><h1>복지지도 지역 검수 33건</h1>';
	if ( $backup && 'applied' === ( $backup['status'] ?? '' ) ) {
		echo '<p><strong>33건의 지역 분류를 반영했습니다.</strong> 다른 사업과 공개 여부는 바꾸지 않았습니다.</p>';
		echo '<p><a href="' . esc_url( admin_url( 'admin.php?page=ebm&tab=status' ) ) . '">복지지도 상태 확인</a></p>';
		echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '"><input type="hidden" name="action" value="ebmrb_restore">';
		wp_nonce_field( 'ebmrb_restore' );
		submit_button( '이번 33건만 적용 전으로 되돌리기', 'secondary' );
		echo '</form></div>'; return;
	}
	if ( $backup ) {
		echo '<p>' . ( 'restored' === ( $backup['status'] ?? '' ) ? '적용 전으로 되돌린 상태입니다. 재적용은 새 검수 후 진행하세요.' : '이전 적용 작업이 완료되지 않은 기록이 있습니다. 추가 적용을 멈추고 확인해 주세요.' ) . '</p></div>';
		return;
	}
	$state = ebmrb_state();
	echo '<p><strong>지금은 미리 보기입니다. 아직 저장하지 않았습니다.</strong></p>';
	echo '<p>지역 분류 33건만 바꿉니다. 확인 필요로 남긴 46건과 이미 반영된 가평군 1건은 그대로 둡니다. 신청 상태·기간·공개 설정은 바꾸지 않습니다.</p>';
	echo '<table class="widefat striped"><thead><tr><th>사업</th><th>적용할 지역</th><th>검수 근거와 주의점</th></tr></thead><tbody>';
	foreach ( ebmrb_plan() as $p ) {
		echo '<tr><td>' . esc_html( $p['name'] ) . '</td><td>' . esc_html( $p['area'] ) . '</td><td>' . esc_html( $p['reason'] ) . ' <a href="' . esc_url( $p['url'] ) . '" target="_blank" rel="noopener noreferrer">복지로 원문</a></td></tr>';
	}
	echo '</tbody></table><form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '">';
	echo '<input type="hidden" name="action" value="ebmrb_apply"><input type="hidden" name="signature" value="' . esc_attr( $state['signature'] ) . '">';
	wp_nonce_field( 'ebmrb_apply' );
	echo '<p><label><input type="checkbox" name="confirm" value="1" required> 위 33건의 지역 분류를 스테이징에 적용합니다.</label></p>';
	submit_button( '이전 값을 백업하고 33건 적용' );
	echo '</form></div>';
}
add_action( 'admin_post_ebmrb_apply', function () {
	ebmrb_check(); check_admin_referer( 'ebmrb_apply' );
	if ( 'POST' !== ( $_SERVER['REQUEST_METHOD'] ?? '' ) || '1' !== ( $_POST['confirm'] ?? '' ) ) { wp_die( '적용 확인이 필요합니다.' ); }
	if ( get_option( ebmrb_backup_key() ) ) { wp_die( '이미 사용한 적용 도구입니다.' ); }
	$state = ebmrb_state();
	$signature = isset( $_POST['signature'] ) ? (string) wp_unslash( $_POST['signature'] ) : '';
	if ( ! hash_equals( $state['signature'], $signature ) ) { wp_die( '미리 보기 이후 검수값이 바뀌었습니다. 새로 확인하세요.' ); }
	$after = array();
	$review = $state['review'];
	foreach ( ebmrb_plan() as $p ) {
		$rv = isset( $review[ $p['id'] ] ) ? (array) $review[ $p['id'] ] : array();
		$rv['sc'] = $p['sc']; $rv['r'] = $p['r'];
		$rv['chk'] = current_time( 'Y-m-d' ); $rv['by'] = get_current_user_id();
		$note = '[지역 검수 2026-10-18] ' . $p['reason'] . ' 근거: ' . $p['url'];
		$rv['memo'] = trim( (string) ( $rv['memo'] ?? '' ) . "\n" . $note );
		$review[ $p['id'] ] = $rv; $after[ $p['id'] ] = $rv;
	}
	$backup = array( 'status' => 'prepared', 'at' => time(), 'before' => $state['before'], 'after' => $after );
	if ( ! add_option( ebmrb_backup_key(), $backup, '', false ) ) { wp_die( '백업을 저장하지 못해 적용을 중단했습니다.' ); }
	if ( ! update_option( 'ebm_review', $review, false ) ) { wp_die( '검수 저장에 실패했습니다. 백업은 남겨 두었습니다.' ); }
	$backup['status'] = 'applied'; update_option( ebmrb_backup_key(), $backup, false );
	ebm_flush_cache();
	wp_safe_redirect( admin_url( 'tools.php?page=ebmrb-batch' ) ); exit;
} );
add_action( 'admin_post_ebmrb_restore', function () {
	ebmrb_check(); check_admin_referer( 'ebmrb_restore' );
	if ( 'POST' !== ( $_SERVER['REQUEST_METHOD'] ?? '' ) ) { wp_die( '잘못된 요청입니다.' ); }
	$backup = get_option( ebmrb_backup_key() );
	if ( ! $backup || 'applied' !== ( $backup['status'] ?? '' ) ) { wp_die( '복원할 적용 기록이 없습니다.' ); }
	$review = ebm_review_all();
	foreach ( $backup['after'] as $id => $expected ) {
		if ( ! isset( $review[ $id ] ) || $review[ $id ] !== $expected ) { wp_die( '적용 후 추가 편집된 항목이 있어 자동 복원을 중단했습니다.' ); }
	}
	foreach ( $backup['before'] as $id => $old ) {
		if ( $old['exists'] ) { $review[ $id ] = $old['value']; } else { unset( $review[ $id ] ); }
	}
	if ( ! update_option( 'ebm_review', $review, false ) ) { wp_die( '복원 저장에 실패했습니다.' ); }
	$backup['status'] = 'restored'; update_option( ebmrb_backup_key(), $backup, false );
	ebm_flush_cache();
	wp_safe_redirect( admin_url( 'tools.php?page=ebmrb-batch' ) ); exit;
} );
