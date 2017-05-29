# plugin-google_analytics
## 설정
### 항목별 획득 방법
#### 프로젝트 명 (Project Name) `optional`
- 구글 api 개발자 [사용자 인증 정보 페이지](https://console.developers.google.com/projectselector/apis/credentials) 상단의 프로젝트 항목에서 생성, 선택된 프로젝트 명을 사용합니다.
- 입력하지 않아도 됩니다.
> 프로젝트 항목은 `Google APIs` 로고 우측에 있습니다.

#### 추적 ID (Tracking ID)
- [구글 analytics 사이트](https://www.google.com/analytics/web/) 이동 합니다.
- 좌측 하단 `관리` 메뉴를 클릭합니다.
- 가운데 `속성` 탭에서 `새 속성 만들기` 선택하여 속성 등록 페이지로 이동 합니다.
- 필요한 정보를 입력 후 `추적 ID 가져오기` 클릭합니다.
- `추적 ID` 항목에 표시된 문자열을 복사합니다.

#### 추적 도메인 (Tracking Domain) `optional`
- 서비스 하는 해당 사이트의 도메인 주소를 입력합니다.
- 입력하지 않아도 되며 입력하지 않는 경우 `auto` 로 설정됩니다.

#### 키 파일 (Key File)
- 구글 api 개발자 [사용자 인증 정보 페이지](https://console.developers.google.com/projectselector/apis/credentials) 이동 합니다.
- `사용자 인증 정보 만들기` 에서  `서비스 계정 키`를 선택합니다.
- 서비스 계정 선택에서 `새 서비스 계정` 을 선택합니다.
- `서비스 계정 이름` 을 입력하고 `역할`을 `Project` -> `뷰어`로 선택 합니다.
- `서비스 계정 ID` 를 복사해 둡니다. (설정에서 `이메일` 항목에 이 값이 들어갑니다.)
- `키 유형` 을 `P12` 로 선택하고 `생성`을 클릭하면 파일이 다운로드 됩니다.

#### 이메일 계정 (Account Email)
- 키 파일 생성시 만들어진 `서비스 계정 ID` 를 사용합니다.
- 생성 후 에는 `사용자 인증 정보` 메뉴 하단에 `서비스 계정 키` 항목에서 `서비스 계정 관리` 를 클릭하여 이동하면 재확인 할 수 있습니다.

#### 프로필 ID, 보기 ID (Profile ID)
- [구글 analytics 사이트](https://www.google.com/analytics/web/) 이동 합니다.
- 좌측 하단 `관리` 메뉴를 클릭합니다.
- 우측 `보기` 탭에서 `설정 보기` 페이지로 이동 합니다.
- `보기 ID` 항목에 표시된 숫자를 복사합니다.

#### 클라이언트 ID (Client ID)
- 구글 api 개발자 [사용자 인증 정보 페이지](https://console.developers.google.com/projectselector/apis/credentials) 이동 합니다.
- `사용자 인증 정보 만들기` 에서 `OAuth 클라이언트 ID`를 선택합니다.
- `웹 어플리케이션`을 선택하고 `생성`을 클릭합니다.
- 생성이 완료되면 `클라이언트 ID`를 복사합니다.

### 추가 설정
#### 사용자 추가
위 항목중 `이메일 계정` 을 구글 analytics 에 사용자로 등록해야 합니다. 
- [구글 analytics 사이트](https://www.google.com/analytics/web/) 에서 `속성` 탭으로 이동합니다.
- `사용자 관리`로 이동하여 `이메일 계정`을 추가하고 권한을 `읽고 분석하기` 로 설정합니다.
