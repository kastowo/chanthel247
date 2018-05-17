    $(document).ready(function() {

      $('#calendar').fullCalendar({

        header: {
          left: 'prev,next today',
          center: 'title',
          right: 'month,agendaWeek,agendaDay,listMonth'
        },
        navLinks: true, // can click day/week names to navigate views
        editable: true,
        eventLimit: true, // allow "more" link when too many events
        events: [
          {
            title: 'Recuritment & Hiring',
            start: '2018-05-03'
          },
          {
            title: 'Pengadaan Barang',
            start: '2018-05-03'
          },
          {
            title: 'Overtime',
            start: '2018-05-02'
          },
          {
            title: 'Pengajuan Cuti',
            start: '2018-05-02'
          },
          {
            title: 'Reimburse',
            start: '2018-04-31'
          },

          // red areas where no events can be dropped
          // hari libur
          {
            start: '2018-05-01',
            end: '2018-05-01',
            rendering: 'background',
            color: '#F03434'
          },
          {
            start: '2018-05-10',
            end: '2018-05-10',
            rendering: 'background',
            color: '#F03434'
          },
          {
            start: '2018-05-29',
            end: '2018-05-29',
            rendering: 'background',
            color: '#F03434'
          }
        ]
      });

    });