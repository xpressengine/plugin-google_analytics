
<p align="center"> 
  <img src="https://raw.githubusercontent.com/xpressengine/plugin-google_analytics/master/icon.png">
 </p>

# XE3 google analytics Plugin
이 어플리케이션은 Xpressengine3(이하 XE3)의 플러그인입니다.

이 플러그인은 XE3에서 Google Analytics 설정 기능을 제공합니다.

[![License](http://img.shields.io/badge/license-GNU%20LGPL-brightgreen.svg)]

# Installation
### Console
```
$ php artisan plugin:install google_analytics
```

### Web install
- 관리자 > 플러그인 & 업데이트 > 플러그인 목록 내에 새 플러그인 설치 버튼 클릭
- `google_analytics` 검색 후 설치하기

### Ftp upload
- 다음의 페이지에서 다운로드
    * https://store.xpressengine.io/plugins/google_analytics
    * https://github.com/xpressengine/plugin-google_analytics/releases
- 프로젝트의 `plugins` 디렉토리 아래 `google_analytics` 디렉토리명으로 압축해제
- `google_analytics` 디렉토리 이동 후 `composer dump` 명령 실행

# Usage
관리자 > 플러그인 & 업데이트 > 플러그인 목록 > Google Analytics > 설정에서 Google Analytics 정보를 입력해서 사용합니다.

## 항목별 획득 방법
### 추적 ID (Tracking ID)
- [구글 analytics 사이트](https://www.google.com/analytics/web/) 이동 합니다.
- 좌측 하단 `관리` 메뉴를 클릭합니다.
- 가운데 `속성` 탭에서 `새 속성 만들기` 선택하여 속성 등록 페이지로 이동 합니다.
- 필요한 정보를 입력 후 `추적 ID 가져오기` 클릭합니다.
- `추적 ID` 항목에 표시된 문자열을 복사합니다.

### 추적 도메인 (Tracking Domain) `optional`
- 서비스 하는 해당 사이트의 도메인 주소를 입력합니다.
- 입력하지 않아도 되며 입력하지 않는 경우 `auto` 로 설정됩니다.

### 키 파일 (Key File)
- 구글 api 개발자 [사용자 인증 정보 페이지](https://console.developers.google.com/projectselector/apis/credentials) 이동 합니다.
- `사용자 인증 정보 만들기` 에서  `서비스 계정 키`를 선택합니다.
- 서비스 계정 선택에서 `새 서비스 계정` 을 선택합니다.
- `서비스 계정 이름` 을 입력하고 `역할`을 `Project` -> `뷰어`로 선택 합니다.
- `서비스 계정 ID` 를 복사해 둡니다. (이메일 형식이며 analytics 사용자에 이 이메일 주소가 등록되어야 합니다.)
- `키 유형` 을 `JSON` 로 선택하고 `생성`을 클릭하면 파일이 다운로드 됩니다.

### 프로필 ID, 보기 ID (Profile ID)
- [구글 analytics 사이트](https://www.google.com/analytics/web/) 이동 합니다.
- 좌측 하단 `관리` 메뉴를 클릭합니다.
- 우측 `보기` 탭에서 `설정 보기` 페이지로 이동 합니다.
- `보기 ID` 항목에 표시된 숫자를 복사합니다.

## 추가 설정
### 사용자 추가
위 항목중 `키 파일` 획득시 생성된 `서비스 계정 ID` (이메일) 를 구글 analytics 에 사용자로 등록해야 합니다. 
- [구글 analytics 사이트](https://www.google.com/analytics/web/) 에서 `속성` 탭으로 이동합니다.
- `사용자 관리`로 이동하여 `이메일`을 추가하고 권한을 `읽고 분석하기` 로 설정합니다.

> `서비스 계정 ID` 는 [사용자 인증 정보 페이지](https://console.developers.google.com/projectselector/apis/credentials) 에서 `서비스 계정 관리` 로 이동하면 확인 할 수 있습니다. 

### API 활성화
- [구글 api 관리자](https://console.developers.google.com/) 페이지로 이동합니다.
- 대시보드에서 `API 사용 설정` 을 클릭합니다.
- 표시되는 API 항목중 `Analytics API` 를 클릭하여 이동합니다.
- `사용 설정` 을 클릭하여 Analytics API 를 활성화 합니다.

## License
이 플러그인은 LGPL라이선스 하에 있습니다. <https://opensource.org/licenses/LGPL-2.1>
