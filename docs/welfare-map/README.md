# 복지지도 인계·병합 기록 (2026-10-18)

Codex 작업 인계 묶음(`인계안내.md`)을 작업 브랜치에 병합한 기록입니다.
- 병합 기준: 스테이징 상태
- 실행하지 않은 것: 패치·검수 도구 재실행, 운영 반영

## 저장소 구조

| 저장소 경로 | 서버 위치 | 운영 배포 대상 |
|---|---|---|
| `generatepress_child/` | `wp-content/themes/generatepress_child/` | 예 (승인 후) |
| `plugins/eb-welfare-map/` | `wp-content/plugins/eb-welfare-map/` | 예 (승인 후) |
| `plugins/eb-schedule/` | `wp-content/plugins/eb-schedule/` | **아니오**: 스테이징에서 받은 참고용 사본. 운영 파일은 바꾸지 않음 |
| `staging/mu-plugins/` | 스테이징 `wp-content/mu-plugins/` | **아니오**: 스테이징 전용 |
| `docs/welfare-map/` | 없음 | 아니오 (기록) |

## functions.php: 스테이징 파일과 저장소 파일의 차이

저장소 파일은 스테이징 최종본(인계 묶음)과 **기능이 같습니다.** 다른 점은 주소 한 가지뿐입니다.

- **주소 차이**: Cloudways가 스테이징을 복제할 때 파일 안의 `easybokji.com` 7곳을 스테이징 주소로 바꿔 놓았습니다(QR 설명, 공유 주소, 앱 설치 안내, SMTP 인사, 일정 파일 PRODID).
  - 저장소에는 운영 주소 `easybokji.com`을 그대로 둡니다. 스테이징 주소가 섞인 파일이 운영에 올라가면 메일과 공유가 잘못되기 때문입니다.
  - 검증: 스테이징 최종본의 스테이징 주소 7곳을 `easybokji.com`으로 되돌리면 저장소 파일과 정확히 같습니다.
- **그 밖의 변경**:
  - `credentials: 'same-origin'` 8곳: 이 브랜치의 앞 커밋에 이미 있음
  - 복지지도 연결 패치 11곳: `map-theme-patch.json`, 이번 커밋에 들어감

스테이징에 저장소 파일을 다시 올릴 필요는 없습니다. 지금 스테이징 파일은 그대로 두세요.

## 스테이징 전용 도구

| 파일 | 상태 |
|---|---|
| `eb-staging-guard.php` | 설치됨. 저장소 파일과 같음 |
| `eb-map-review-export.php` | 설치됨. 관리자 다운로드만 함 |
| `eb-map-review-batch.php` | **이미 실행함. 다시 누르지 말 것.** 33건 적용, 백업 옵션 `ebmrb_backup_20261018_v1` |

## DB에만 있는 것 (GitHub에 자동으로 저장되지 않음)

| 항목 | 위치 |
|---|---|
| 지역 검수값 33건 (+ 가평군 1건) | 스테이징 DB 옵션 `ebm_review` |
| 공개 여부 | `ebm_public` = 0 (관리자 미리 보기) |

운영 반영 때는 **스테이징 DB를 운영에 덮어쓰지 말고**, `ebm_review`의 해당 항목만 내보내 운영에 넣는 선택 이관을 따로 준비합니다(승인 후).

## 이번 병합에서 확인한 것

- 인계 묶음 47개 파일 SHA256 일치
- PHP 문법 검사: `functions.php`, 복지지도 9개, mu-plugins 3개, eb-schedule 6개 모두 오류 없음
- JSON 21개 읽기 정상
- 임시 WordPress에서 홈·맞춤 찾기 열기와 복지지도 짧은 코드(관리자) 실행 시 PHP 경고·오류 0건
- 방문자 상태에서 `/welfare-map/` 404, `ebm/v1` API 401 → 미리 보기 상태(비공개) 유지 확인
- 비밀번호·API 키로 보이는 값 없음 (검사함)

## 아직 확인 안 한 것

- 스테이징 서버 파일과 저장소의 해시 직접 비교: 서버 접근 불가. 스테이징 최종본은 인계 묶음을 기준으로 함
- `css/` 파일은 인계 묶음에 없음. 스테이징 CSS에도 주소 바꾸기가 적용됐을 수 있음(저장소 CSS의 `easybokji.com` 3곳). 기능 차이는 없을 것으로 보지만 **확인 필요**
- 실기기 모바일·키보드·터치 회귀 시험, tocer 오류 원인, 보류 46건
