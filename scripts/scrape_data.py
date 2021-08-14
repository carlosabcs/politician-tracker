from bs4 import BeautifulSoup
from datetime import datetime, date, timedelta
import re
import requests

class PoliticianScraper:

    URLS = {
        'presidential_office': 'https://appw.presidencia.gob.pe/visitas/transparencia/index_server.php?k=sbmtBuscar',
    }

    def __init__(self, begin_date, end_date) -> None:
        begin_date = datetime.strptime(begin_date, '%d/%m/%Y')
        end_date = datetime.strptime(end_date, '%d/%m/%Y')
        delta = end_date - begin_date
        self.dates = [ begin_date + timedelta(days=i) for i in range(delta.days + 1) ]
        pass


    def __get_number_from_string(self, string) -> int:
        return int(re.search(r'\d+', string).group())


    def get_presidential_visits(self, date) -> list:
        response = requests.post(
            self.URLS['presidential_office'],
            data={ 'valorCaja1': date, }
        )
        soup = BeautifulSoup(response.text, 'html.parser')
        row_count = self.__get_number_from_string(soup.span.text)
        rows = soup.find_all('tr')
        assert(len(rows) - 1 == row_count) # The first rows contain a text with the number of rows

        meetings = []
        for row in rows:
            cells = row.find_all('td')
            if len(cells) != 11: # The number of fields...
                print('Esto solo se salta una vez')
                continue

            try:
                meeting = {
                    'visitor_name': cells[2].text,
                    'visitor_document': cells[3].text,
                    'visitor_entity': cells[4].text,
                    'meeting_reason': cells[5].text,
                    'public_employee_name': cells[6].text,
                    'public_employee_position': cells[7].span.text,
                    'office_name': cells[7].span.previousSibling,
                    'meeting_start_time': f'{cells[1].text} {cells[8].text}:00',
                    'meeting_end_time': f'{cells[1].text} {cells[9].text}:00',
                    'observation': cells[10].text,
                }
                meetings.append(meeting)
            except:
                print('Failed for', row)
                raise
        return meetings




BEGIN_DATE = '28/07/2021'
END_DATE = datetime.today().strftime('%d/%m/%Y')

ps = PoliticianScraper(BEGIN_DATE, END_DATE)
for date in ps.dates:
    print(ps.get_presidential_visits(date.strftime('%d/%m/%Y')))
    break
