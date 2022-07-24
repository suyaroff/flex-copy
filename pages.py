from selenium import webdriver
from selenium.webdriver import ActionChains
from selenium.webdriver.common.by import By
import time

driver = webdriver.Chrome("W:\WebDriver\chromedriver.exe")
driver.set_window_size(1900, 1000)

with open('urls.txt', 'r') as fp:
    # считываем сразу весь файл
    data = fp.read()

for line in data.splitlines(False):
    print(line)
    if (line):
        try:
            driver.get(line)
            time.sleep(1)
            try:
                elements = driver.find_elements(By.CLASS_NAME, "card-link")
                for number in range(len(elements)-1):
                    links = driver.find_elements(By.CLASS_NAME, "card-link")
                    try:
                        element = links[number]
                        try:
                            element.click()
                            time.sleep(0.5)
                            driver.back()
                            time.sleep(0.5)
                        except Exception:
                            print('не клинулось')
                    except Exception:
                        print('Такого элемента нет')
            except Exception:
                print('Элементов нет '+line)
        except Exception:
            print('Страница не загрузилась '+line)
