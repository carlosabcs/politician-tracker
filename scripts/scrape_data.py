from bs4 import BeautifulSoup
from datetime import datetime, date, timedelta
import re
import requests


class PoliticianScraper:

    DOMAINS = {
        'PRESIDENT': 'https://appw.presidencia.gob.pe/',
        'PCM': 'https://visitas.servicios.gob.pe/',
    }

    SERVICES = {
        'PRESIDENT': 'visitas/transparencia/index_server.php?k=sbmtBuscar',
        'PCM': 'consultas/dataBusqueda.php',
    }

    RUCS = {
        'PCM': 20168999926,
    }

    def __init__(self, begin_date, end_date) -> None:
        begin_date = datetime.strptime(begin_date, '%d/%m/%Y')
        end_date = datetime.strptime(end_date, '%d/%m/%Y')
        delta = end_date - begin_date
        self.dates = [
            begin_date + timedelta(days=i) for i in range(delta.days + 1)
        ]
        pass

    def __get_number_from_string(self, string) -> int:
        return int(re.search(r'\d+', string).group())

    def __date_time_to_single_string(self, date, time) -> str:
        return f'{date} {time}:00'

    def __make_request(
        self,
        method,
        endpoint,
        params=None
    ) -> requests.Response:
        if method == 'POST':
            return requests.post(endpoint, data=params)
        return requests.get(endpoint)

    def get_presidential_visits(self, date) -> list:
        response = self.__make_request(
            'POST',
            f"{self.DOMAINS['PRESIDENT']}{self.SERVICES['PRESIDENT']}",
            {'valorCaja1': date, }
        )
        soup = BeautifulSoup(response.text, 'html.parser')
        row_count = self.__get_number_from_string(soup.span.text)
        rows = soup.find_all('tr')

        # The first rows contain a text with the number of rows
        if len(rows) - 1 != row_count:
            raise Exception(f'Wrong number of rows, expected: {row_count}')

        meetings = []
        for row in rows[1:]:
            cells = row.find_all('td')
            if len(cells) != 11:  # The number of fields...
                raise Exception('Wrong number of fields.')

            try:
                start_time = self.__date_time_to_single_string(
                    cells[1].text,
                    cells[8].text
                )
                end_time = self.__date_time_to_single_string(
                    cells[1].text,
                    cells[9].text
                )
                meeting = {
                    'visitor_name': cells[2].text,
                    'visitor_document': cells[3].text,
                    'visitor_entity': cells[4].text,
                    'meeting_reason': cells[5].text,
                    'public_employee_name': cells[6].text,
                    'public_employee_position': cells[7].span.text,
                    'public_employee_office': cells[7].span.previousSibling,
                    'meeting_start_time': start_time,
                    'meeting_end_time': end_time,
                    'observation': cells[10].text,
                }
                meetings.append(meeting)
            except Exception:
                print('Failed for', row)
                raise
        return meetings

    def get_pcm_visits(self, begin_date, end_date) -> list:
        response = self.__make_request(
            'POST',
            f"{self.DOMAINS['PCM']}{self.SERVICES['PCM']}",
            {
                'busqueda': self.RUCS['PCM'],
                'fecha': f'{begin_date} - {end_date}',
            }
        )
        response.encoding = "utf-8-sig"
        decoded_data = response.json()
        meetings = []
        try:
            for meeting in decoded_data['data']:
                public_employee_info = meeting['funcionario'].split('-')
                if len(public_employee_info) != 3:
                    raise Exception(f'Can not decode public employee info')
                start_time = self.__date_time_to_single_string(
                    meeting['fecha'],
                    meeting['horaIn']
                )
                end_time = self.__date_time_to_single_string(
                    meeting['fecha'],
                    meeting['horaOut']
                )
                meetings.append({
                    'visitor_name': meeting['visitante'],
                    'visitor_document': None,
                    'visitor_entity': meeting['rz_empresa'],
                    'meeting_reason': meeting['motivo'],
                    'public_employee_name': public_employee_info[0],
                    'public_employee_position': public_employee_info[2],
                    'public_employee_office': public_employee_info[1],
                    'meeting_start_time': start_time,
                    'meeting_end_time': end_time,
                    'observation': '',  # No observation found
                })
            return meetings
        except Exception:
            print('Failed for meeting:', meeting)


BEGIN_DATE = '28/07/2021'
END_DATE = datetime.today().strftime('%d/%m/%Y')

ps = PoliticianScraper(BEGIN_DATE, END_DATE)
ps.get_pcm_visits(
    ps.dates[0].strftime('%d/%m/%Y'),
    ps.dates[-1].strftime('%d/%m/%Y')
)
for date in ps.dates:
    print(ps.get_presidential_visits(date.strftime('%d/%m/%Y')))
    break
