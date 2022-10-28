import i18next from 'i18next';

i18next
  .init({
    interpolation: {
      // React already does escaping
      escapeValue: false,
    },
    lng: getLanguage(), // 'en' | 'es'
    // Using simple hardcoded resources for simple example
    resources: {
      en: {
        translation: {
            month: {
                label: 'Month',
                January: 'January',
                February: 'February',
                March: 'March',
                April: 'April',
                May: 'May',
                June: 'June',
                July: 'July',
                August: 'August',
                September: 'September',
                October: 'October',
                November: 'November',
                December: 'December'

            },
            surveys: {
                conducted: 'surveys conducted'
            },
            other: {
                call: 'calls',
                surveys_sended: 'emails sended',
                surveys_respond: 'emails respond',
                visits: 'visits',
                view_more: 'View more',
                period: 'Number of cases in the investigation period',
                telephone: 'Number of responses to telephone surveys',
                email: 'Number of e-mail surveys',
                responses: 'Number of responses to email surveys',
                contacted: 'Percentage of visits contacted',
                rate: 'Reponse rate',
                total: 'Total response rate',
                reporting: 'Reporting period',
                unanswered: 'View unanswered',
                answers: 'Answers',
                shop_unanswered: 'Shops not respond',
                code: 'Code',
                name: 'Name',
                not_respond: 'Not Respond',
                valoration: 'Valoration',
                comment: 'Comment',
                previous: 'Previous',
                next: 'Next',
                open_inc: 'Openc incidence',
                inc_close: 'Incidence close',
                timing: 'Time average',
                congratulations: 'Congratulations'
            },
            answer: {
              first: 'What overall score would you give us?',
              second: 'Rate the speed of our service',
              third: 'Appreciates the friendliness of our technicians',
              fourth: 'Scores the resolution capacity of the incidences'
            }
        },
      },
      es: {
        translation: {
            month: {
                label: 'Mes',
                January: 'Enero',
                February: 'Febrero',
                March: 'Marzo',
                April: 'Abril',
                May: 'Mayo',
                June: 'Junio',
                July: 'Julio',
                August: 'Agosto',
                September: 'Septiembre',
                October: 'Octubre',
                November: 'November',
                December: 'December'
            },
            surveys: {
                conducted: 'Encuentas realizadas'
            },
            other: {
                call: 'calls',
                surveys_sended: 'emails enviados',
                surveys_respond: 'emails respondidos',
                visits: 'visitas',
                view_more: 'Ver más',
                period: 'Cantidad de visitas',
                telephone: 'Cantidad de respuestas a las llamadas',
                email: 'Cantidad de emails enviados',
                responses: 'Cantidad de respuestas de emails',
                contacted: 'Porcentaje de visitas contactadas',
                rate: 'Tasa de respuesta',
                total: 'Tasa de respuestas total',
                reporting: 'Periodo de reporte',
                unanswered: 'Ver sin respuesta',
                answers: 'Respuestas',
                shop_unanswered: 'Tiendas sin respuesta',
                code: 'Código',
                name: 'Nombre',
                not_respond: 'No Responde',
                valoration: 'Valoración',
                comment: 'Comentario',
                previous: 'Anterior',
                next: 'Siguiente',
                open_inc: 'Incidencias abiertas',
                inc_close: 'Incidencias cerradas',
                timing: 'Tiempo promedio',
                congratulations: 'Felicitaciones'
            },
            answer: {
              first: '¿Qué puntuación global nos darías?',
              second: 'Valoración de la rapidez de nuestro servicio',
              third: 'Valoración de la amabilidad de nuestros técnicos',
              fourth: 'Valoración de la capacidad de resolver incidencias'
            }
        },
      },
    },
  })

function getLanguage() {
    let acceptLanguage = ['es','en'];
    let language = window.navigator.language.slice(0,window.navigator.language.indexOf('-'));
    return (acceptLanguage.indexOf(language) > -1) ? language : 'en';
}

export default i18next