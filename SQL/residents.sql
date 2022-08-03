DROP TABLE IF EXISTS `residents`;
CREATE TABLE IF NOT EXISTS `residents` (
  `id` int(4) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `Surname` varchar(40) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `MiddlName` varchar(50),
  `Password` BINARY(16),
  `Email` VARCHAR(255),
  `Phone1` CHAR (15),
  `Phone2` CHAR (15),
  `isMember` BOOLEAN DEFAULT true
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `residents`
--
INSERT INTO `residents` (`Surname`, `Name`, `MiddlName`,  `Email`, `Phone1`, `Phone2`) VALUES
( "Абросова", "Татьяна", "Борисовна", "w@w", "0667119188", "" ),
( "Андрющенко", "Антонина", "Юрьевна", "09antonina@gmail.com", "0982248904", "" ),
( "Астафьев", "Виктор", "Всеволодович", "w@w", "0988409450", "" ),
( "Белоненко", "Неля", "Сергеевна", "w@w", "0982795984", "" ),
( "Белоненко", "Николай", "Иванович", "w@w", "0982795984", "" ),
( "Белоус", "Юрий", "Владимирович", "3310095@gmail.com", "0980319002", "" ),
( "Беляева", "Татьяна", "Борисовна", "w@w", "0976381972", "" ),
( "Бережинский", "Игорь", "Леонидович", "w@w", "0507622824", "" ),
( "Биденко", "Костянтин", "Витальевич", "kosbidenko@gmail.com", "0672207308", "" ),
( "Бирюкова", "Елена", "Дмитриевна", "w@w", "0679441613", "" ),
( "Бобровицкая", "Лидия", "Степановна", "w@w", "0975492981", "" ),
( "Богданова", "Мария", "Ивановна", "w@w", "0666522820", "" ),
( "Бондар", "А.", "П.", "bondar.prima@gmail.com", "0673840116", "" ),
( "Бондар", "Людмила", "Борисовна", "w@w", "098", "" ),
( "Бондаренко", "Нини", "Алексеевна", "w@w", "098", "" ),
( "Борисова", "Елена", "Павловна", "lyaskovskiy29@gmail.com", "0660937870", "" ),
( "Борщик", "Валентина", "Ивановна", "w@w", "0985379700", "" ),
( "Бохонський", "Иван", "Данилович", "w@w", "0675855479", "" ),
( "Бреус", "Виталий", "Валентинович", "vitaha7684@gmail.com", "0685055218", "" ),
( "Бугар", "Алла", "Васильевна", "W@w", "0674417584", "" ),
( "Бугар", "Ю.", "В.", "bugary20@gmail.com", "0672959207", "" ),
( "Буренок", "Юрий", "Юрьевич", "w@w", "0968009633", "" ),
( "Бурковская", "Анна", "Михайловна", "w@w", "0673022020", "" ),
( "Бурлака", "Юрий", "Григорьевич", "w@w", "0672675202", "0963006691" ),
( "Бутенко", "Ольга", "Александровна", "w@w", "098", "" ),
( "Васильченко", "Виктор", "Леонидович", "karlzzoy@ukr.net", "0976910707", "" ),
( "Васькивська", "Надежда", "|", "|", "|", "" ),
( "Веклич", "Елена", "Афанасивна", "olenavek@ukr.net", "0975753164", "" ),
( "Вережак", "Татьяна", "Николаевна", "w@w", "067", "" ),
( "Вижва", "Зоя", "Александровна", "zoya_vyzhva@ukr.net", "0636735525", "" ),
( "Винник", "Василь", "Васильевич", "w@w", "0983950475", "" ),
( "Вирко", "Виктория", "Владимировна", "w@w", "0675052251", "" ),
( "Волошин", "Александр", "борисович", "w@w", "0662182172", "" ),
( "Воробйова", "Валентина", "Петровна", "w@w", "0671092086", "" ),
( "Вязьмитинов", "Егор", "Николаевич", "w@w", "0675371537", "" ),
( "Гаврилова", "Светлана", "Михаловна", "w@w", "0972892239", "" ),
( "Гадзинська", "Инна", "Павловна", "jeko@ua.FM", "+380672610539", "" ),
( "Гамбул", "Валентина", "Федоровна", "w@w", "098", "" ),
( "Ганусец", "Юрий", "Евгеньевич", "6968280@gmail.com", "0506968280", "" ),
( "Гапоненко", "Григорий", "Михайлович", "w@w", "0672399460", "" ),
( "Гарбузюк", "Оксана", "Васильевна", "w@w", "0674053976", "" ),
( "Гаркуша", "Н.", "В.", "w@w", "0966646464", "" ),
( "Гирич", "Людмила", "Евгенивна", "w@w", "067", "" ),
( "Глущенко", "Валентина", "Матвеевна", "w@w", "0935957363", "" ),
( "Головач", "Ольга", "Яковлевна", "w@w", "0666374930", "" ),
( "Голомша", "Татьяна", "Кирриловна", "w@w", "0679348333", "" ),
( "Гончарук", "Кристина", "Петровна", "w@w", "0683402328", "" ),
( "Грабин", "Игорь", "В.", "anna@gtp3.kiev.ua", "0503315107", "" ),
( "Гранюк", "Людмила", "Алексеевна", "w@w", "098", "" ),
( "Грецкая", "Людмила", "Игоревна", "vlboiko150@gmail.com", "0509822419", "" ),
( "Григоренко", "Руслан", "Анатольевич", "W@w", "0504422801", "" ),
( "Григорьев", "Дмитрий", "Олегович", "w@w", "067", "" ),
( "Григорьев", "Олег", "Николаевич", "w@w", "0502380779", "" ),
( "Григорьева", "Л.", "М.", "w@w", "0965587840", "" ),
( "Гринь", "Николай", "Евдокимович", "w@w", "098", "" ),
( "Гусакова", "Людмила", "Николаевна", "w@w", "0672844052", "" ),
( "Гутовська", "Людмила", "Кирриловна", "iamLkgutovska@ukr.net", "0503322723", "" ),
( "Давиднеко", "Святослав", "Васильевич", "w@w", "0937673249", "" ),
( "Даниленко", "М.", "М.", "w@w", "067", "" ),
( "Дегтярьова", "Наталья", "Николаевна", "w@w", "098", "" ),
( "Деденко", "Марина", "Сергеевна", "w@w", "0675041810", "" ),
( "Дементьев", "Сергей", "Александрович", "w@w", "0679078971", "" ),
( "Дичко", "Богдан", "Петрович", "w@w", "0675033837", "" ),
( "Довбуш", "А.", "Д.", "w@w", "067", "" ),
( "Довбуш", "Ирина", "Петровна", "w@w", "0964411604", "" ),
( "Довгомеля", "Иван", "Федорович", "w@w", "0679600099", "" ),
( "Довгомеля", "Ирина", "Владимировна", "w@w", "067", "" ),
( "Дорошенко", "Ольга", "Сергеевна", "w@w", "0678648309", "" ),
( "Дроботун", "Василь", "Володимирович", "W@w", "0975787686", "" ),
( "Дрозд", "Екатерина", "петровна", "w@w", "098", "" ),
( "Душечкина", "Лидия", "Григорьевна", "w@w", "0667514867", "" ),
( "Ермакова", "Юлианна", "Г.", "yulianayer@gmail.com", "0678391810", "" ),
( "Ермилов", "Виктор", "Иванович", "w@w", "0976067861", "" ),
( "Ермилова", "Вера", "Никитовна", "w@w", "0976067861", "" ),
( "Ефименко", "Владимир", "Станиславович", "w@w", "098", "" ),
( "Ефименко", "Владислав", "Владимирович", "w@w", "098", "" ),
( "Жарова", "Лариса", "Борисовна", "zharov1886@gmail.com", "0634624949", "" ),
( "Жур", "Татьяна", "Вадимировна", "w@w", "0679527985", "" ),
( "Журавель", "Василий", "николаевич", "w@w", "0975422395", "" ),
( "Журавская", "Наталья", "Витальевна", "w@w", "0971029697", "" ),
( "Заболотько", "Михаил", "Ильич", "w@w", "0677720950", "" ),
( "Забродская", "Ольга", "Вадимовна", "w@w", "098", "" ),
( "Забродський", "Иосиф", "Григорьевич", "w@w", "098", "" ),
( "Завадський", "Виталий", "Леонидович", "w@w", "0980627385", "" ),
( "Заика", "Александр", "Лукич", "w@w", "0973414614", "" ),
( "Зайцева", "Людмила", "Николаевна", "w@w", "0688292998", "" ),
( "Залевский", "Владимир", "Анатольевич", "w@w", "0932791980", "" ),
( "Западня", "Ганна", "Станиславовна", "shtepa_77@ukr.net", "0962302189", "" ),
( "Золотар", "Людмила", "Владимировна", "luzolotar@gmail.com", "0672203260", "" ),
( "Зубенко", "Владлена", "Кузьмивна", "w@w", "0973439273", "" ),
( "Зубченко", "Татьяна", "Филипповна", "w@w", "0673064263", "" ),
( "Зуева", "Людмила", "Юрьевна", "merired2205@ukr.net", "0677356904", "" ),
( "Иваницкий", "В.", "А.", "w@w", "067", "" ),
( "Иванова", "Null", "Null", "w@w", "0971596485", "" ),
( "Иванчук", "Алексей", "Емильевич", "ivancuk1@jahoo.com", "0675006505", "" ),
( "Иващенко", "Игорь", "Николаевич", "w@w", "0975187890", "" ),
( "Иченец", "Зинаида", "Федоровна", "w@w", "0975846186", "" ),
( "Калашник", "Надежда", "Владимировна", "w@w", "098", "" ),
( "Калюта", "Галина", "Борисовна", "opal-k@ukr.net", "0985287831", "" ),
( "Кангина", "Светлана", "Васильевна", "s.v.56@gmeta.ua", "0982260038", "" ),
( "Картузов", "Валерий", "Васильевич", "my.kartuz@gmail.com", "0971939624", "" ),
( "Кварелашвили", "Валентина", "Евгенивна", "w@w", "067", "" ),
( "Кириенко", "Ирина", "Николаевна", "w@w", "0977245017", "" ),
( "Кисиленко", "Лидия", "Ивановна", "w@w", "0671134993", "" ),
( "Клюгвант", "Валентина", "Васильевна", "w@w", "067", "" ),
( "Коваленко", "Г.", "О.", "w@w", "0931142593", "" ),
( "Ковальова", "Олександра", "Олексеевна", "w@w", "0979199584", "" ),
( "Козаченко", "Александр", "Викторович", "a.kozachenko75@gmail.com", "0674071240", "" ),
( "Козачук", "В.", "В.", "w@w", "0974562117", "" ),
( "Козинцева", "Раиса", "А.", "creditline.bdd@gmail.com", "0957800816", "" ),
( "Козленко", "Лианна", "Ивановна", "w@w", "067", "" ),
( "Козлов", "Владислав", "Иванович", "w@w", "0671501496", "" ),
( "Козориз", "Олексей", "Иванович", "ko.sergey2011@gmail.com", "0671073837", "" ),
( "Коломийчук", "София", "Григорьевна", "w@w", "0687615948", "" ),
( "Конюшевский", "Иван", "Иосипович", "w@w", "0965357091", "" ),
( "Корзанова", "Алла", "Яковна", "w@w", "0991728209", "" ),
( "Король", "Любовь", "Ивановна", "w@w", "0679859708", "" ),
( "Королькова", "Елена", "Якимна", "tetiana.korolkova419@gmail.com", "0636590654", "" ),
( "Королюк", "Вадим", "Федорович", "w@w", "067", "" ),
( "Королюк", "Вячеслав", "Вадимович", "kaso3883@gmail.com", "0672667878", "" ),
( "Костюк", "Борис", "Дмитриевич", "w@w", "0973431999", "" ),
( "Коцар", "Олег", "Викторович", "kovbox@ukr.net", "0673705361", "" ),
( "Кочуба", "Елена", "Анатолиевна", "w@w", "0964562323", "" ),
( "Кошара", "Мария", "алексеевна", "w@w", "0986143489", "" ),
( "Кравченко", "Иван", "Викторович", "w@w", "380674573864", "" ),
( "Кравченко", "Ирина", "Григорьевна", "i.materova79@mail.com", "0679929656", "" ),
( "Кракович", "Юрий", "Владимирович", "w@w", "0675061658", "" ),
( "Кудревич", "Раиса", "Александровна", "tigrik92kpi@gmail.com", "0502428606", "" ),
( "Кудряшова", "Алла", "Анатольевна", "w@w", "0967385808", "" ),
( "Кулай", "Т.", "А.", "w@w", "0679158474", "" ),
( "Кулик", "Владимир", "Васильевич", "w@w", "0962297152", "" ),
( "Курина", "Нина", "Петровна", "w@w", "0675029551", "" ),
( "Куровская", "Юлия", "Владимировна", "w@w", "0973183467", "" ),
( "Ландар", "Т.", "Г.", "w@w", "0677996092", "" ),
( "Лебединская", "Татьяна", "Петровна", "w@w", "0985507000", "" ),
( "Лебедь", "Оксана", "Дмитриевна", "Lebed_ork@ua.fm", "0675972519", "" ),
( "Лебидь", "Александр", "Григорьевич", "w@w", "098", "" ),
( "Лебидь", "Григорий", "Николаевич", "w@w", "098", "" ),
( "Ленок", "Валентина", "Николаевна", "w@w", "098", "" ),
( "Линникова", "Анна", "Владимировна", "w@w", "0676868313", "" ),
( "Литвинчук", "Владимир", "Ф.", "w@w", "067", "" ),
( "Лихач", "Виталий", "Леонидович", "w@w", "0986080435", "" ),
( "Лобода", "Александр", "Павлович", "w@w", "0674494520", "" ),
( "Лукьянец", "Анна", "григорьевна", "w@w", "0971246134", "" ),
( "Луценко", "Татьяна", "Владимировна", "tatyana.v.lutsenko@gmail.com", "0975487388", "" ),
( "Лучкевич", "Татьяна", "Null", "luchtaty@ukr.net", "0675007377", "" ),
( "Ляпунов", "Виктор", "Петрович", "w@w", "0675266904", "" ),
( "Макельський", "Олександр", "Васильевич", "prepressprint@gmail.com", "0638517051", "" ),
( "Максимова", "Ирина", "Михаловна", "w@w", "0677720950", "" ),
( "Малиновская", "Лариса", "Николаевна", "w@w", "0975754894", "" ),
( "Мамонова", "Лоида", "Денисовна", "jwnikolaybondarev@gmail.com", "0634850997", "" ),
( "Мамонова", "С.", "И.", "w@w", "0989108012", "" ),
( "Маркович", "Ольга", "Алексеевна", "w@w", "0974096894", "" ),
( "Мартиненко", "Анна", "Николаевна", "w@w", "098", "" ),
( "Марущак", "Василий", "Иванович", "w@w", "0679696047", "" ),
( "Марчук", "Володимир", "Иванович", "w@w", "0981069825", "" ),
( "Марчук", "Таисия", "Ивановна", "w@w", "0981069825", "" ),
( "Масленко", "Юрий", "Пилипович", "w@w", "067", "" ),
( "Махмуд", "Лика", "Null", "AS@gmail.ua", "0504699543", "" ),
( "Мацкевич", "Бронислава", "Степановна", "w@w", "0973740974", "" ),
( "Мельник", "Анжелика", "Юрьевна", "w@w", "0677045547", "" ),
( "Мельник", "Наталья", "Владимировна", "w@w", "0967732423", "" ),
( "Мельник", "Ольга", "Null", "ninele@ukr.net", "0963623106", "" ),
( "Мельник", "Степан", "Васильевич", "w@w", "0674577215", "" ),
( "Мельник", "Таисия", "Степановна", "w@w", "0677850284", "" ),
( "Мельниченко", "Людмила", "Викторовна", "w@w", "0984088859", "" ),
( "Менська", "Ганна", "Михайловна", "w@w", "0971921969", "" ),
( "Мизюк", "Александр", "Валентинович", "aleksanndrmizuk74@gmail.com", "0683731827", "" ),
( "Минаков", "Николай", "Вениаминович", "w@w", "098", "" ),
( "Минакова", "Анна", "Вениаминовна", "anna@gtp3.kiev.ua", "0503315107", "" ),
( "Миронец", "Дмитрий", "Константинович", "mirdmkonst57@gmail.com", "0674461363", "" ),
( "Миронова", "Галина", "Васильевна", "w@w", "0671938650", "" ),
( "Мирошниченко", "К.", "Д.", "w@w", "0979166558", "" ),
( "Мирошниченко", "Людмила", "Леонидовна", "76miroshnychenko@gmail.com", "0986422221", "" ),
( "Молчанова", "О.", "М.", "w@w", "0955902722", "" ),
( "Мукиева", "Вера", "Григорьевна", "w@w", "0987824332", "" ),
( "Мусатов", "Сергей", "Александрович", "w@w", "0955288482", "" ),
( "Назар", "Виктор", "Владимирович", "w@w", "0504625814", "" ),
( "Назаренко", "Анелия", "Степановна", "w@w", "098", "" ),
( "Нафасов", "Рустам", "Туркманович", "w@w", "0977011172", "" ),
( "Нежинская", "Нелля", "Викторовна", "w@w", "+380679620306", "" ),
( "Нефьедов", "Вадим", "Олегович", "nefedovvadim1@gmail.com", "0667071957", "" ),
( "Нечай", "Е.", "Д.", "w@w", "067118749", "" ),
( "Николаев", "Вадим", "Александровичь", "w@w", "098", "" ),
( "Николаенко", "А.", "Ю.", "Juliakrasnova999@gmail.com", "0504461744", "" ),
( "Николаенко", "А.", "Ю.", "Juliakrasnova999@gmail.com", "0504461744", "" ),
( "Оверченко", "Алла", "Анатолиевна", "w@w", "0982127859", "" ),
( "Олейник", "Дмитрий", "Николаевич", "w@w", "0509970391", "" ),
( "Онищенко", "Александр", "Николаевич", "w@w", "098", "" ),
( "Онищенко", "Николай", "Семенович", "w@w", "0974321522", "" ),
( "Осадчая", "Татьяна", "Анатольевна", "w@w", "0961962030", "" ),
( "Осипов", "Евгений", "Викторович", "w@w", "0671670490", "" ),
( "Осипова", "Валентина", "Антоновна", "w@w", "0671670490", "" ),
( "Папян", "Ирина", "Викторовна", "w@w", "0989495666", "" ),
( "Паранчук", "Лариса", "Григорьевна", "w@w", "0973529568", "" ),
( "Пастушенко", "Ростислав", "Петрович", "w@w", "0678130924", "" ),
( "Пахарь", "Григорий", "Васильеич", "w@w", "0509386633", "" ),
( "Паясь", "Сергей", "Николаевич", "w@w", "0964897837", "" ),
( "Петренко", "Владимир", "Ананолиевич", "w@w", "0631206242", "" ),
( "Петров", "Владимир", "Владимирович", "w@w", "0671822088", "" ),
( "Петрова", "Татьяна", "Анатольевна", "mishele2000@gmail.com", "0965260955", "" ),
( "Печентковсая", "Александра", "Денисовна", "vgmtd@ukr.net", "0508439817", "" ),
( "Пилипенко", "Юрий", "Степанович", "w@w", "0679003059", "" ),
( "Писанко", "Игорь", "Всеволодович", "w@w", "0963974109", "" ),
( "Погорелова", "Валентина", "Викторовна", "w@w", "0962527735", "" ),
( "Поливянный", "Виталий", "Петрович", "w@w", "0672631894", "" ),
( "Полищук", "В.", "И.", "w@w", "0501111111", "" ),
( "Половинко", "Володимир", "Степанович", "Vpolovynko@gmail.com", "0672322564", "" ),
( "Пономаренко", "Валентина", "Алексеевна", "w@w", "0961522342", "" ),
( "Приведа", "Василий", "Павлович", "lorrka@ukr.net", "0676595339", "" ),
( "Приходько", "Максим", "Гигорович", "max.prikhodko@gmail.com", "0679591257", "" ),
( "Приходько", "Тамара", "Степановна", "w@w", "0965036653", "" ),
( "Проминь", "Null", "Null", "W@w", "0968929108", "" ),
( "Пряха", "Александр", "Борисович", "pryakhaa@gmail.com", "0677804046", "" ),
( "Пушня", "Николай", "Иванович", "mgkbud@gmail.com", "0509067458", "" ),
( "РОДНИЧОК", "|", "alexandr@zayats.org", "NULL", "", "" ),
( "Ременюк", "Галина", "Александровна", "galinagalo4ka56@gmail.com", "0964858869", "" ),
( "Рибицкий", "Леонид", "Лаврентиевич", "w@w", "0503843723", "0965513798" ),
( "Розмаитин", "Анатолий", "Леонидович", "w@w", "0675062635", "" ),
( "Руденко", "Инна", "Николаевна", "w@w", "+380672587453", "" ),
( "Руденко", "Олег", "Васильевич", "w@w", "0972988322", "" ),
( "Рудис", "Татьяна", "Васильевна", "ZGR@jmail.com", "0503862090", "" ),
( "Савельев", "Георгий", "Борисович", "w@w", "0974907107", "" ),
( "Савчук", "Ольга", "Null", "w@w", "0674414151", "" ),
( "Садовникова", "Наталия", "Станиславовна", "w@w", "0980464267", "" ),
( "Саенко", "Людмила", "Вячеславовна", "litvinchuksergey2507@ukr.net", "0979446883", "" ),
( "Самаренко", "Светлана", "Генриевна", "ssamarenko@gmail.com", "0677038044", "" ),
( "Селько", "Михаил", "Васильевич", "w@w", "0962473253", "" ),
( "Сергиенко", "Ирина", "Николаевна", "irina_nikolaevna17@i.ua", "0977102834", "" ),
( "Серова", "Светлана", "Владимировна", "SerovaS@i.ua", "0633075147", "" ),
( "Синьковская", "Антонина", "Юрьевна", "w@w", "098", "" ),
( "Сичев", "Валентин", "Васильевич", "w@w", "0671319445", "" ),
( "Сичов", "Александр", "Егорович", "w@w", "0989473893", "" ),
( "Сичов", "Илья", "Валентинович", "beaton@bigmik.net", "0632312448", "" ),
( "Скопенко", "Артур", "Анатольевич", "w@w", "0673279248", "0637615483" ),
( "Скрипка", "Лариса", "Константиновна", "w@w", "098", "" ),
( "Слободянык", "Дарья", "Null", "Daria_Slobodianyk@ukr.ua", "0953147303", "" ),
( "Слобожанинов", "Иван", "Дмитриевич", "w@w", "067", "" ),
( "Смольников", "Юрий", "Борисович", "w@w", "0952535767", "0687027465" ),
( "Снопова", "Наталья", "Юрьевна", "Nataliya.Snopova@heidelbeng.com", "0977442050", "0503844611" ),
( "Соколова", "Наталья", "Николаевна", "ns1961@ukr.net", "0674069663", "" ),
( "Соломатина", "Алена", "Юрьевна", "w@w", "098", "" ),
( "Суботович", "Растислав", "Игоревич", "w@w", "098", "" ),
( "Сутко", "Алексей", "Андреевич", "w@w", "0674794642", "" ),
( "Сухенко", "Федор", "Васильевич", "w@w", "0958274208", "" ),
( "Таранец", "Михаил", "Алексеевич", "mitaranets@gmail.com", "0674076187", "" ),
( "Тимошенко", "Татьяна", "Викторовна", "w@w", "0505516232", "" ),
( "Титенко", "Людмила", "Валериевна", "w@w", "0674439671", "" ),
( "Ткач", "Алиса", "Игоревна", "alisa.tkach49@gmail.ru", "0935846821", "" ),
( "Ткаченко", "Вадим", "Эдуардович", "w@w", "0672475171", "" ),
( "Ткаченко", "Н.", "Н.", "hheLg@ukr.net", "0734205003", "" ),
( "Ткаченко", "Юлия", "Ю.", "w@w", "0957838739", "" ),
( "Толстоног", "М.", "О.", "w@w", "0672965070", "" ),
( "Трасковский", "Сергей", "Витальевич", "w@w", "0938646980", "" ),
( "Трипольская", "Олена", "Олександровна", "hj@gmail.com", "0968175313", "" ),
( "Труш", "В.", "М.", "w@w", "0677524468", "" ),
( "Тучак", "Галина", "Сергеевна", "w@w", "098", "" ),
( "Фещенко", "Катерина", "Ивановна", "w@w", "067", "" ),
( "Филоненко", "Александр", "Александрович", "w@w", "0975570101", "" ),
( "Филоненко", "Сергей", "Александрович", "w@w", "098", "" ),
( "Филяк", "Вадим", "Васильевич", "w@w", "0504422094", "" ),
( "Фоменко", "Галина", "Николаевка", "w@w", "0662264339", "0951113009" ),
( "Фролова", "Мария", "Алексеевна", "w@w", "067", "" ),
( "Халковська", "З.", "И.", "w@w", "067", "" ),
( "Хижняк", "Валентина", "Васильевна", "Valentina_Hyzhnyak@ukr.net", "0677519177", "" ),
( "Химерик", "Леонид", "Иванович", "w@w", "0985380483", "" ),
( "Хоменко", "Г.", "В.", "w@w", "098", "" ),
( "Цветкова", "Татьянана", "Алексеевна", "w@w", "0973028409", "0975387355" ),
( "Черик", "М.", "А.", "w@w", "067", "" ),
( "Черныш", "Валентина", "Павловна", "w@w", "0970249674", "" ),
( "Чоповская", "Вера", "Петровна", "w@w", "0663153479", "" ),
( "Шаркова", "Людмила", "Григорьевна", "w@w", "0671424780", "" ),
( "Шевченко", "Тамара", "Ильинична", "alexandr@zayats.org", "0504432829", "" ),
( "Шевчук", "Александр", "Николаевич", "w@w", "0637201905", "" ),
( "Шепель", "Галина", "Николаевна", "w@w", "0667027650", "" ),
( "Шиленко", "Надежда", "Степановна", "w@w", "0973169393", "" ),
( "Широкова", "Елена", "|", "|", "|", "" ),
( "Шишкина", "Евгения", "Мефодиивна", "w@w", "0951311396", "" ),
( "Шкуренко", "Елена", "Ивановна", "w@w", "+380664600060", "" ),
( "Шленчак", "В.", "В.", "w@w", "0964889279", "" ),
( "Якубовская", "Валентина", "Брониславивна", "4vbf@i.ua", "0955471574", "" ),
( "Ярош", "Владимир", "Виталиевич", "w@w", "0674073246", "" ),
( "Яценко", "Людмила", "Станиславовна", "w@w", "0679684294", "" ),
( "Ячменева", "Вера", "Петровна", "w@w", "098", "" )
