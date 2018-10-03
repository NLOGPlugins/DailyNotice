# DailyNotice
Send Form when player join server

### 접속 시 뜨는 메세지 설정
```<데이터폴더>/DailyNotice/setting.yml``` 을 열어주세요.

```title```은 Form의 제목, ```message```는 Form의 content 입니다.

```title과 message의 값에 아래의 변수를 사용할 수 있습니다.```
| 변수            | 값                                              |
|-----------------|-------------------------------------------------|
| @playername     | 플레이어 이름                                   |
| @playercount    | 현재 플레이어 접속자 수                         |
| @playermaxcount | 서버에 접속할 수 있는 최대 플레이어 수          |
| @motd           | 서버 motd                                       |
| @mymoney        | 플레이어 돈 EconomyAPI 미적용 시 undefined 출력 |
| @health         | 플레이어 체력                                   |
| @maxhealth      | 플레이어 최대 체력 (기본: 20)                   |
| @year           | 연도                                            |
| @month          | 달                                              |
| @day            | 날짜                                            |
| @hour           | 시                                              |